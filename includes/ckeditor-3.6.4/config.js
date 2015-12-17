/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	config.toolbar_Basic =
	[
		{ name: 'basic',      items : [ 'Source','Bold','Italic','NumberedList','BulletedList','Link','Unlink','Maximize' ] }
	];
	
	config.toolbar_Full =
	[
		{ name: 'document',    items : [ 'Source','PasteText' ] },
		{ name: 'styles',      items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','RemoveFormat', 'NumberedList','BulletedList','Outdent','Indent','CreateDiv','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','BidiLtr','BidiRtl','Link','Unlink' ] },
		'/',
		{ name: 'styles',      items : [ 'Format','Font','FontSize' ] },
		{ name: 'colors',      items : [ 'Styles','TextColor','BGColor','Image','Table','HorizontalRule','SpecialChar' ] },
		{ name: 'tools',       items : [ 'Maximize','ShowBlocks' ] }
	];
	
	// This is actually the default value.
	/*config.toolbar_Full =
	[
		{ name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
		{ name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		{ name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
		{ name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
		'/',
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
		{ name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
		'/',
		{ name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
		{ name: 'colors',      items : [ 'TextColor','BGColor' ] },
		{ name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-','About' ] }
	];*/
	
	config.skin = 'v2';
	
	config.filebrowserBrowseUrl      = '/includes/ckeditor-3.6.4/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '/includes/ckeditor-3.6.4/ckfinder/ckfinder.html?Type=Images';
	config.filebrowserFlashBrowseUrl = '/includes/ckeditor-3.6.4/ckfinder/ckfinder.html?Type=Flash';
	config.filebrowserUploadUrl      = '/includes/ckeditor-3.6.4/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '/includes/ckeditor-3.6.4/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = '/includes/ckeditor-3.6.4/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};
