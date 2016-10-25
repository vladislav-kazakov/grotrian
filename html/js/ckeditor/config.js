/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
	 config.language = 'ru'; 
	 
	 config.toolbar_MyToolbar =
		 [
		 	{ name: 'document', items : [ 'Source' ] },
		 	{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
		 	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		 	{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock' ] },
		 	{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
		 	{ name: 'insert', items : [ 'Image','Table','HorizontalRule' ] },
		 	'/',
		 	{ name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
		 	{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		 	{ name: 'tools', items : [ 'Maximize','ShowBlocks' ] }
		 ];
	// config.uiColor = '#AADC6E';
};
