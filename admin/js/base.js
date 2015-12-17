function CreateAjaxForm(id)
{
	if($('#ajax-item-id').val())
	{
		CancelAjaxForm($('#ajax-item-id').val());
	}
	
	var fields = $('#ajax-fields').val().split(',');
	
	if($('#upload_target').get(0))
	{
		var classFile = $('#class-file').val();
		var className = $('#class-name').val();
		$('#image_'+id).before('<form action="ajax.base.php?classfile='+classFile+'&classname='+className+'&uploadimage='+id+'" method="post" enctype="multipart/form-data" target="upload_target"><input type="file" name="image" /></form>');
	}
	
	for(i=0; i<fields.length; i++)
	{
		if($('#'+fields[i]+'_'+id).attr('class') == 'field-text') // Text
		{
			$('#'+fields[i]+'_'+id).before('<input type="text" alt="ajax" class="ajax-input-text" name="'+fields[i]+'" id="'+fields[i]+'" value="'+$('#'+fields[i]+'_'+id).text()+'" />');
		}
		else if($('#'+fields[i]+'_'+id).attr('class') == 'field-number') // Number
		{
			$('#'+fields[i]+'_'+id).before('<input type="text" alt="ajax" class="ajax-input-number" name="'+fields[i]+'" id="'+fields[i]+'" value="'+$('#'+fields[i]+'_'+id).text()+'" />');
		}
		else if($('#'+fields[i]+'_'+id).attr('class') == 'field-textarea') // Textarea
		{
			$('#'+fields[i]+'_'+id).before('<textarea alt="ajax" class="ajax-input-textarea" name="'+fields[i]+'" id="'+fields[i]+'" rows="5" cols="50">'+$('#'+fields[i]+'_'+id).text()+'</textarea>');
		}
		else if($('#'+fields[i]+'_'+id).attr('class') == 'field-html') // Html
		{
			$('#'+fields[i]+'_'+id).before('<div id="div_'+fields[i]+'" alt="html"></div>');
			CreateHtmlEditor(fields[i]);
		}
		else if($('#'+fields[i]+'_'+id).attr('class') == 'field-flag') // Flag
		{
			$('#'+fields[i]+'_'+id).before('<input alt="ajax" type="checkbox" class="ajax-input-flag" name="'+fields[i]+'" id="'+fields[i]+'" '+($('#'+fields[i]+'_'+id).children().children().attr('class')=='icon-on' ? 'checked="checked" ' : '')+'/>');
		}
		else if($('#'+fields[i]+'_'+id).attr('class') == 'field-select') // Select
		{
			$('#ajax-select-'+fields[i]).children().clone().insertBefore('#'+fields[i]+'_'+id);
			$('#'+fields[i]+'_'+id).prev().attr("id", fields[i]).attr("name", fields[i]).attr("alt", "ajax");
			var selectElement = $('#'+fields[i]).get(0);
			for(j=0; j<selectElement.length; j++)
			{
				if($('#'+fields[i]+'_'+id).text() == selectElement.options[j].text)
				{
					selectElement.selectedIndex = j;
				}
			}
		}
		else if($('#'+fields[i]+'_'+id).attr('class') == 'field-date') // Date
		{
			$('#'+fields[i]+'_'+id).before('<input type="text" alt="ajax" class="ajax-input-date" name="'+fields[i]+'" id="'+fields[i]+'" value="'+$('#'+fields[i]+'_'+id).text()+'" />');
			$('#'+fields[i]).datepicker();
		}
		
		$('#'+fields[i]+'_'+id).hide();
	}
	
	$('#item_button_'+id).next().show();
	$('#item_button_'+id).hide();
	
	$('#ajax-item-id').val(id);
	
	return false;
}

function SaveAjaxForm(id)
{
	var classFile = $('#class-file').val();
	var className = $('#class-name').val();
	
	if($('#upload_target').get(0))
	{
		$('#image_'+id).prev().submit();
	}
	
	var fields = $('#ajax-fields').val().split(',');
	var htmlValues = "";
	
	if(typeof(FCKeditorAPI) != 'undefined')
	{
		var htmlElements = $('div[alt="html"]');
		
		htmlElements.each(function(index){
			var fieldName = $(this).children().eq(0).get(0).name;
			var oEditor = FCKeditorAPI.GetInstance(fieldName);
			if(oEditor) {htmlValues += "&"+encodeURIComponent(fieldName)+"="+encodeURIComponent(oEditor.GetXHTML());}
		});
	}
	
	$.ajax({
		type: "POST",
		url: "ajax.base.php?classfile="+classFile+"&classname="+className+"&saveitem="+id,
		data: $(":input[alt='ajax']").serializeArray(),
		beforeSend: function(XMLHttpRequest)
		{
			this.data += htmlValues;
			$('#item_button_'+id).next().next().show();
			$('#item_button_'+id).next().hide();
			$("#ajax-dialog").dialog({
				bgiframe: true,
				height: 50,
				title: 'Сохранение данных',
				modal: true
			});
		},
		success: function(data, textStatus)
		{
			if($.string(data).isJSON())
			{
				data = $.string(data).evalJSON();
				if(data.status == "success")
				{
					UpdateAjaxForm(id);
					$('#item_button_'+id).parent().parent().effect('highlight');
				}
				else
				{
					alert('Ajax error:\n\n'+data.error);
				}
			}
			else
			{
				alert('Ajax error:\n\n'+data);
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown)
		{
			alert('Ajax request error');
		},
		complete: function(XMLHttpRequest, textStatus)
		{
			$("#ajax-dialog").dialog('destroy');
			CancelAjaxForm(id);
		}
	});
	
	return false;
}

function UpdateAjaxForm(id)
{
	var fields = $('#ajax-fields').val().split(',');
	
	for(i=0; i<fields.length; i++)
	{
		if(
			$('#'+fields[i]+'_'+id).attr('class') == 'field-text' ||
			$('#'+fields[i]+'_'+id).attr('class') == 'field-number' ||
			$('#'+fields[i]+'_'+id).attr('class') == 'field-textarea' ||
			$('#'+fields[i]+'_'+id).attr('class') == 'field-date'
			)
		{
			$('#'+fields[i]+'_'+id).text($('#'+fields[i]).val());
		}
		else if($('#'+fields[i]+'_'+id).attr('class') == 'field-flag') // Flag
		{
			//var imgPath = $('#'+fields[i]+'_'+id).find('img').attr('src').substr(0, $('#'+fields[i]+'_'+id).find('img').attr('src').lastIndexOf("/")+1);
			var className = $('#'+fields[i]).get(0).checked ? 'icon-on' : 'icon-off';
			$('#'+fields[i]+'_'+id).children().children().attr('class',className);
		}
		else if($('#'+fields[i]+'_'+id).attr('class') == 'field-select') // Select
		{
			var selectElement = $('#'+fields[i]).get(0);
			$('#'+fields[i]+'_'+id).text(selectElement.options[selectElement.selectedIndex].text);
		}
		else if($('#'+fields[i]+'_'+id).attr('class') == 'field-html') // Html
		{
			if(typeof(FCKeditorAPI) !== undefined)
			{
				var htmlElement = $('#div_'+fields[i]+'[alt="html"]');
				var oEditor = FCKeditorAPI.GetInstance(fields[i]);
				if(oEditor)
				{
					var htmlValue = oEditor.GetXHTML();
					$(htmlElement).next().next().html(htmlValue);
					var htmlString = $.string(htmlValue).stripTags().truncate(240).str;
					$(htmlElement).next().html(htmlString);
				}
			}
		}
	}
	
	return true;
}

function CancelAjaxForm(id)
{
	if($('#upload_target').get(0))
	{
		$('#image_'+id).prev().remove();
	}
	
	var fields = $('#ajax-fields').val().split(',');
	
	for(i=0; i<fields.length; i++)
	{
		$('#'+fields[i]+'_'+id).prev().remove();
		$('#'+fields[i]+'_'+id).show();
	}
	
	$('#item_button_'+id).show();
	$('#item_button_'+id).next().hide();
	$('#item_button_'+id).next().next().hide();
	
	$('#ajax-item-id').val('');
	
	return true;
}

function ToggleField(element, id, field)
{
	var classFile = $('#class-file').val();
	var className = $('#class-name').val();
	$.ajax({
		type: "GET",
		url: "ajax.base.php?classfile="+classFile+"&classname="+className+"&togglefield="+field+'&id='+id,
		beforeSend: function(XMLHttpRequest)
		{
			$(element).hide();
			$(element).after('<span class="icon-loading"></span>');
		},
		success: function(data, textStatus)
		{
			if($.string(data).isJSON())
			{
				data = $.string(data).evalJSON();
				if(data.status == "success")
				{
					var className = data.value ? 'icon-on' : 'icon-off';
					$(element).children().attr('class', className);
				}
				else
				{
					alert('Ajax error:\n\n'+data.error);
				}
			}
			else
			{
				alert('Ajax error:\n\n'+data);
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown)
		{
			alert('Ajax request error');
		},
		complete: function(XMLHttpRequest, textStatus)
		{
			$(element).next().remove();
			$(element).show();
		}
	});
	
	return false;
}

function MoveItem(element, id, direction, where)
{
	if(
		(direction == 'up' && $(element).parent().parent().prev().prev().get(0) && $(element).parent().parent().prev().prev().get(0).tagName.toUpperCase() == "TR") ||
		(direction == 'down' && $(element).parent().parent().next().get(0) && $(element).parent().parent().next().get(0).tagName.toUpperCase() == "TR")
		)
	{
		var classFile = $('#class-file').val();
		var className = $('#class-name').val();
		$.ajax({
			type: "GET",
			url: "ajax.base.php?classfile="+classFile+"&classname="+className+"&moveitem="+id+"&direction="+direction+"&where="+where,
			beforeSend: function(XMLHttpRequest)
			{
				$(element).hide();
				$(element).after('<img src="/admin/img/loading.gif" alt="" />');
			},
			success: function(data, textStatus)
			{
				if($.string(data).isJSON())
				{
					data = $.string(data).evalJSON();
					if(data.status == "success")
					{
						$(element).parent().parent().stop();
						
						if(direction == 'up')
						{
							var class1 = $(element).parent().parent().attr('class');
							var class2 = $(element).parent().parent().prev().attr('class');
							$(element).parent().parent().addClass('tr-highlighted');
							$(element).parent().parent().fadeTo('fast',1, function () {
								$(this).insertBefore($(this).prev());
								$(this).fadeTo('fast', 1, function () {$(element).parent().parent().attr('class',class2);});
							});
							$(element).parent().parent().prev().fadeTo('fast',0, function () {$(this).attr('class',class1);$(this).fadeTo('fast', 1)});
						}
						else
						{
							var class1 = $(element).parent().parent().attr('class');
							var class2 = $(element).parent().parent().next().attr('class');
							$(element).parent().parent().addClass('tr-highlighted');
							$(element).parent().parent().fadeTo('fast',1, function () {
								$(this).insertAfter($(this).next());
								$(this).fadeTo('fast', 1, function () {$(element).parent().parent().attr('class',class2);});
							});
							$(element).parent().parent().next().fadeTo('fast',0, function () {$(this).attr('class',class1);$(this).fadeTo('fast', 1)});
						}
					}
					else
					{
						alert('Ajax error:\n\n'+data.error);
					}
				}
				else
				{
					alert('Ajax error:\n\n'+data);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
				alert('Ajax request error');
			},
			complete: function(XMLHttpRequest, textStatus)
			{
				$(element).next().remove();
				$(element).show();
			}
		});
	}
	
	return false;
}

function DeleteItem(element, id)
{
	if(confirm('Вы действительно хотите удалить запись #'+id))
	{
		var classFile = $('#class-file').val();
		var className = $('#class-name').val();
		$.ajax({
			type: "GET",
			url: "ajax.base.php?classfile="+classFile+"&classname="+className+"&deleteitem="+id,
			beforeSend: function(XMLHttpRequest)
			{
				$(element).hide();
				$(element).after('<img src="/admin/img/loading.gif" alt="" />');
			},
			success: function(data, textStatus)
			{
				if($.string(data).isJSON())
				{
					data = $.string(data).evalJSON();
					if(data.status == "success")
					{
						$(element).parent().parent().fadeOut();
					}
					else
					{
						alert('Ajax error:\n\n'+data.error);
					}
				}
				else
				{
					alert('Ajax error:\n\n'+data);
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{
				alert('Ajax request error');
			},
			complete: function(XMLHttpRequest, textStatus)
			{
				$(element).next().remove();
				$(element).show();
			}
		});
	}
	
	return false;
}

function DeleteImage(element, fileName)
{
	var classFile = $('#class-file').val();
	var className = $('#class-name').val();
	$.ajax({
		type: "GET",
		url: "ajax.base.php?classfile="+classFile+"&classname="+className+"&deleteimage="+fileName,
		beforeSend: function(XMLHttpRequest)
		{
			$(element).html('<img src="/admin/img/loading.gif" alt="" />');
		},
		success: function(data, textStatus)
		{
			if($.string(data).isJSON())
			{
				data = $.string(data).evalJSON();
				if(data.status == "success")
				{
					$(element).parent().fadeOut();
				}
				else
				{
					alert('Ajax error:\n\n'+data.error);
				}
			}
			else
			{
				alert('Ajax error:\n\n'+data);
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown)
		{
			alert('Ajax request error');
		},
		complete: function(XMLHttpRequest, textStatus)
		{
			$(element).html('');
		}
	});
	
	return false;
}

function InitializeForm(formId)
{
	// Make not-empty fields notification
	$('#'+formId).submit(function() {
		var inputs = $('#'+formId+" :input.not-empty");
		var valid  = true;
		inputs.each(function() {
			if( !$.trim($(this).val()) )
			{
				$(this).focus();
				$(this).css({backgroundColor:"#ff9"});
				valid = false;
				return false;
			}
			else
			{
				$(this).css({backgroundColor:""});
			}
		});
		return valid;
	});

	// Make date fields
	var dateInputs = $('#'+formId+" :input.input-date");
	dateInputs.each(function(){
		$(this).datepicker();
	});

	// Make time fields
	var timeInputs = $('#'+formId+" :input.input-time");
	timeInputs.each(function(){
		$(this).timepickr({trigger: 'focus',rangeMin:['00','05','10','15','20','25','30','35','40','45','50','55']});
	});

	// Make set fields
	var setInputs = $('#'+formId+" :input.input-set");
	setInputs.each(function(){
		var setSelected = $(this).parent().find(".set-item-on");
		var setItemsArray = Array();

		$.each(setSelected, function(i, val) {
			setItemsArray[i] = $(val).attr('title');
		});

		$(this).attr('value', setItemsArray.join(','));
	});

	// Make number fields
	$('#'+formId+' :input.input-number').keypress(function(event) {
		var chars = "0123456789.";
		var chr = String.fromCharCode(event.charCode === undefined ? event.keyCode : event.charCode);
		return event.ctrlKey || (chr < ' ' || chars.indexOf(chr) > -1);
	});
}

function CreateHtmlEditor(fieldName)
{
	var oFCKeditor = new FCKeditor(fieldName);
  oFCKeditor.BasePath = FCKEditorPath;
	oFCKeditor.ToolbarSet = "Light";
	oFCKeditor.Width = 306;
	oFCKeditor.Height = 150;
	oFCKeditor.Value = $('#div_'+fieldName+'[alt="html"]').next().next().html();
	
	$('#div_'+fieldName+'[alt="html"]').html(oFCKeditor.CreateHtml());
	
	return true;
}

function FileSubmitted(id, status, data)
{
	if(status)
	{
		datetime = new Date();
		$('#image_'+id).html('<img src="'+$('#image_path').val()+data+'?datetime='+datetime.toUTCString()+'" alt="" />');
	}
	else
	{
		alert("Ошибка закачки файла");
	}
}

function ToggleSetItem(element)
{
	$(element).toggleClass('set-item-on');
	var setSelected = $(element).parent().find(".set-item-on");

	var setItemsArray = Array();
	$.each(setSelected, function(i, val) {
		setItemsArray[i] = $(val).attr('title');
	});
	
	$(element).parent().children('input').attr('value', setItemsArray.join(','));
}

function OpenNewSetForm(element, classFile, className, fieldName, fieldKey)
{
	$("#add-set-dialog").dialog({
		title: 'Добавление значения',
		height: 100,
		width: 350,
		resizable: false,
		modal: true,
		buttons: {
			'Отмена': function() {
				$(this).dialog('close');
			},
			'Сохранить': function() {
				if($.trim( $('#new_set_value').val() ))
				{
					$.ajax({
						type: "POST",
						url: "ajax.base.php?classfile="+classFile+"&classname="+className+"&additem=1",
						data: fieldKey+"=&"+fieldName+"="+$.trim($('#new_set_value').val()),
						beforeSend: function(XMLHttpRequest)
						{
							$("#add-set-dialog").dialog('destroy');

							$("#ajax-dialog").dialog({
								bgiframe: true,
								height: 50,
								title: 'Сохранение данных',
								modal: true
							});
						},
						success: function(data, textStatus)
						{
							if($.string(data).isJSON())
							{
								data = $.string(data).evalJSON();
								if(data.status == "success")
								{
									$('<span class="set-item" title="'+data.id+'" onclick="ToggleSetItem(this);">'+$.trim($('#new_set_value').val())+'</span><em> </em>').insertBefore($(element));
								}
								else
								{
									alert('Ajax error:\n\n'+data.error);
								}
							}
							else
							{
								alert('Ajax error:\n\n'+data);
							}
						},
						error: function(XMLHttpRequest, textStatus, errorThrown)
						{
							alert('Ajax request error');
						},
						complete: function(XMLHttpRequest, textStatus)
						{
							$('#new_set_value').val('');
							$("#ajax-dialog").dialog('destroy');
						}
					});
				}
				else
				{
					alert('Введите значение');
					$('#new_set_value').focus();
					return false;
				}
			}
		},
		close: function() {
			$('#new_set_value').val('');
			$(this).dialog('destroy');
		}
	});

	$('#new_set_value').focus();

}