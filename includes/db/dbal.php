<?php
/**
* Database Abstraction Layer
* @package dbal
*/
class dbal
{
	var $db_connect_id;
	var $query_result;
	var $transaction = false;
	var $sql_time = 0;
	var $num_queries = array();
	var $open_queries = array();

	var $curtime = 0;
	var $query_hold = '';
	var $html_hold = '';
	var $sql_report = '';
	
	var $persistency = false;
	var $user = '';
	var $server = '';
	var $dbname = '';

	// Set to true if error triggered
	var $sql_error_triggered = false;

	// Holding the last sql query on sql error
	var $sql_error_sql = '';

	// Holding transaction count
	var $transactions = 0;

	// Supports multi inserts?
	var $multi_insert = false;

	/**
	* Current sql layer
	*/
	var $sql_layer = '';

	/**
	* Wildcards for matching any (%) or exactly one (_) character within LIKE expressions
	*/
	var $any_char;
	var $one_char;

	/**
	* Constructor
	*/
	function dbal()
	{
		$this->num_queries = array(
			'normal'		=> 0,
			'total'			=> 0,
		);

		// Fill default sql layer based on the class being called.
		// This can be changed by the specified layer itself later if needed.
		$this->sql_layer = substr(get_class($this), 5);

		// Do not change this please! This variable is used to easy the use of it - and is hardcoded.
		$this->any_char = chr(0) . '%';
		$this->one_char = chr(0) . '_';
	}

	/**
	* Return number of sql queries used
	*/
	function sql_num_queries()
	{
		return $this->num_queries['normal'];
	}

	/**
	* Add to query count
	*/
	function sql_add_num_queries()
	{
		$this->num_queries['normal'] += 1;
		$this->num_queries['total'] += 1;
	}

	/**
	* DBAL garbage collection, close sql connection
	*/
	function sql_close()
	{
		if (!$this->db_connect_id)
		{
			return false;
		}

		if ($this->transaction)
		{
			do
			{
				$this->sql_transaction('commit');
			}
			while ($this->transaction);
		}

		foreach ($this->open_queries as $query_id)
		{
			$this->sql_freeresult($query_id);
		}
		
		return $this->_sql_close();
	}

	/**
	* Build LIMIT query
	* Doing some validation here.
	*/
	function sql_query_limit($query, $total, $offset = 0)
	{
		if (empty($query))
		{
			return false;
		}

		// Never use a negative total or offset
		$total = ($total < 0) ? 0 : $total;
		$offset = ($offset < 0) ? 0 : $offset;

		return $this->_sql_query_limit($query, $total, $offset);
	}

	/**
	* Fetch all rows
	*/
	function sql_fetchrowset($query_id = false)
	{
		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		if ($query_id !== false)
		{
			$result = array();
			while ($row = $this->sql_fetchrow($query_id))
			{
				$result[] = $row;
			}

			return $result;
		}
		
		return false;
	}

	/**
	* Fetch field
	* if rownum is false, the current row is used, else it is pointing to the row (zero-based)
	*/
	function sql_fetchfield($field, $rownum = false, $query_id = false)
	{
		if ($query_id === false)
		{
			$query_id = $this->query_result;
		}

		if ($query_id !== false)
		{
			if ($rownum !== false)
			{
				$this->sql_rowseek($rownum, $query_id);
			}

			$row = $this->sql_fetchrow($query_id);
			return (isset($row[$field])) ? $row[$field] : false;
		}

		return false;
	}

	/**
	* Correctly adjust LIKE expression for special characters
	* Some DBMS are handling them in a different way
	*
	* @param string $expression The expression to use. Every wildcard is escaped, except $this->any_char and $this->one_char
	* @return string LIKE expression including the keyword!
	*/
	function sql_like_expression($expression)
	{
		$expression = str_replace(array('_', '%'), array("\_", "\%"), $expression);
		$expression = str_replace(array(chr(0) . "\_", chr(0) . "\%"), array('_', '%'), $expression);

		return $this->_sql_like_expression('LIKE \'' . $this->sql_escape($expression) . '\'');
	}

	/**
	* SQL Transaction
	* @access private
	*/
	function sql_transaction($status = 'begin')
	{
		switch ($status)
		{
			case 'begin':
				// If we are within a transaction we will not open another one, but enclose the current one to not loose data (prevening auto commit)
				if ($this->transaction)
				{
					$this->transactions++;
					return true;
				}

				$result = $this->_sql_transaction('begin');

				if (!$result)
				{
					$this->sql_error();
				}

				$this->transaction = true;
			break;

			case 'commit':
				// If there was a previously opened transaction we do not commit yet... but count back the number of inner transactions
				if ($this->transaction && $this->transactions)
				{
					$this->transactions--;
					return true;
				}

				$result = $this->_sql_transaction('commit');

				if (!$result)
				{
					$this->sql_error();
				}

				$this->transaction = false;
				$this->transactions = 0;
			break;

			case 'rollback':
				$result = $this->_sql_transaction('rollback');
				$this->transaction = false;
				$this->transactions = 0;
			break;

			default:
				$result = $this->_sql_transaction($status);
			break;
		}

		return $result;
	}

	/**
	* Build sql statement from array for insert/update/select statements
	*
	* Idea for this from Ikonboard
	* Possible query values: INSERT, INSERT_SELECT, MULTI_INSERT, UPDATE, SELECT
	*
	*/
	function sql_build_array($query, $assoc_ary = false)
	{
		if (!is_array($assoc_ary))
		{
			return false;
		}

		$fields = $values = array();

		if ($query == 'INSERT' || $query == 'INSERT_SELECT')
		{
			foreach ($assoc_ary as $key => $var)
			{
				$fields[] = $key;

				if (is_array($var) && is_string($var[0]))
				{
					// This is used for INSERT_SELECT(s)
					$values[] = $var[0];
				}
				else
				{
					$values[] = $this->_sql_validate_value($var);
				}
			}

			$query = ($query == 'INSERT') ? ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $values) . ')' : ' (' . implode(', ', $fields) . ') SELECT ' . implode(', ', $values) . ' ';
		}
		else if ($query == 'MULTI_INSERT')
		{
			$ary = array();
			foreach ($assoc_ary as $id => $sql_ary)
			{
				// If by accident the sql array is only one-dimensional we build a normal insert statement
				if (!is_array($sql_ary))
				{
					return $this->sql_build_array('INSERT', $assoc_ary);
				}

				$values = array();
				foreach ($sql_ary as $key => $var)
				{
					$values[] = $this->_sql_validate_value($var);
				}
				$ary[] = '(' . implode(', ', $values) . ')';
			}

			$query = ' (' . implode(', ', array_keys($assoc_ary[0])) . ') VALUES ' . implode(', ', $ary);
		}
		else if ($query == 'UPDATE' || $query == 'SELECT')
		{
			$values = array();
			foreach ($assoc_ary as $key => $var)
			{
				$values[] = "$key = " . $this->_sql_validate_value($var);
			}
			$query = implode(($query == 'UPDATE') ? ', ' : ' AND ', $values);
		}

		return $query;
	}

	/**
	* Build IN or NOT IN sql comparison string, uses <> or = on single element
	* arrays to improve comparison speed
	*
	* @access public
	* @param	string	$field				name of the sql column that shall be compared
	* @param	array	$array				array of values that are allowed (IN) or not allowed (NOT IN)
	* @param	bool	$negate				true for NOT IN (), false for IN () (default)
	* @param	bool	$allow_empty_set	If true, allow $array to be empty, this function will return 1=1 or 1=0 then. Default to false.
	*/
	function sql_in_set($field, $array, $negate = false, $allow_empty_set = false)
	{
		if (!sizeof($array))
		{
			if (!$allow_empty_set)
			{
				// Print the backtrace to help identifying the location of the problematic code
				$this->sql_error('No values specified for SQL IN comparison');
			}
			else
			{
				// NOT IN () actually means everything so use a tautology
				if ($negate)
				{
					return '1=1';
				}
				// IN () actually means nothing so use a contradiction
				else
				{
					return '1=0';
				}
			}
		}

		if (!is_array($array))
		{
			$array = array($array);
		}

		if (sizeof($array) == 1)
		{
			@reset($array);
			$var = current($array);

			return $field . ($negate ? ' <> ' : ' = ') . $this->_sql_validate_value($var);
		}
		else
		{
			return $field . ($negate ? ' NOT IN ' : ' IN ') . '(' . implode(', ', array_map(array($this, '_sql_validate_value'), $array)) . ')';
		}
	}

	/**
	* Run more than one insert statement.
	*
	* @param string $table table name to run the statements on
	* @param array &$sql_ary multi-dimensional array holding the statement data.
	*
	* @return bool false if no statements were executed.
	* @access public
	*/
	function sql_multi_insert($table, &$sql_ary)
	{
		if (!sizeof($sql_ary))
		{
			return false;
		}

		if ($this->multi_insert)
		{
			$this->sql_query('INSERT INTO ' . $table . ' ' . $this->sql_build_array('MULTI_INSERT', $sql_ary));
		}
		else
		{
			foreach ($sql_ary as $ary)
			{
				if (!is_array($ary))
				{
					return false;
				}

				$this->sql_query('INSERT INTO ' . $table . ' ' . $this->sql_build_array('INSERT', $ary));
			}
		}

		return true;
	}

	/**
	* Function for validating values
	* @access private
	*/
	function _sql_validate_value($var)
	{
		if (is_null($var))
		{
			return 'NULL';
		}
		else if (is_string($var))
		{
			return "'" . $this->sql_escape($var) . "'";
		}
		else
		{
			return (is_bool($var)) ? intval($var) : $var;
		}
	}

	/**
	* Build sql statement from array for select and select distinct statements
	*
	* Possible query values: SELECT, SELECT_DISTINCT
	*/
	function sql_build_query($query, $array)
	{
		$sql = '';
		switch ($query)
		{
			case 'SELECT':
			case 'SELECT_DISTINCT';

				$sql = str_replace('_', ' ', $query) . ' ' . $array['SELECT'] . ' FROM ';

				$table_array = array();
				foreach ($array['FROM'] as $table_name => $alias)
				{
					if (is_array($alias))
					{
						foreach ($alias as $multi_alias)
						{
							$table_array[] = $table_name . ' ' . $multi_alias;
						}
					}
					else
					{
						$table_array[] = $table_name . ' ' . $alias;
					}
				}

				$sql .= $this->_sql_custom_build('FROM', implode(', ', $table_array));

				if (!empty($array['LEFT_JOIN']))
				{
					foreach ($array['LEFT_JOIN'] as $join)
					{
						$sql .= ' LEFT JOIN ' . key($join['FROM']) . ' ' . current($join['FROM']) . ' ON (' . $join['ON'] . ')';
					}
				}

				if (!empty($array['WHERE']))
				{
					$sql .= ' WHERE ' . $this->_sql_custom_build('WHERE', $array['WHERE']);
				}

				if (!empty($array['GROUP_BY']))
				{
					$sql .= ' GROUP BY ' . $array['GROUP_BY'];
				}

				if (!empty($array['ORDER_BY']))
				{
					$sql .= ' ORDER BY ' . $array['ORDER_BY'];
				}

			break;
		}

		return $sql;
	}

	/**
	* display sql error page
	*/
	function sql_error($sql = '')
	{
		// Set var to retrieve errored status
		$this->sql_error_triggered = true;
		$this->sql_error_sql = $sql;

		$error = $this->_sql_error();

		if ($this->transaction)
		{
			$this->sql_transaction('rollback');
		}

		return $error;
	}
}

/**
* This variable holds the class name to use later
*/
$sql_db = (!empty($dbType)) ? 'dbal_' . basename($dbType) : 'dbal';

?>