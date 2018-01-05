/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function(config){
	config.skin = 'office2013';
	config.toolbar = [
		['Source', 'Maximize', '-', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'], 
		['Undo', 'Redo', 'SelectAll', 'Styles', 'Format', 'Font', 'FontSize', 'TextColor', 'BGColor'],
		'/', 
		['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'], 
		['Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', '-', 'Link', 'Unlink', '-'], 
		['Table', 'HorizontalRule', 'PageBreak', 'Iframe', '-', 'About'],
	];
	// config.font_names = 'Calibri;Arial;Times New Roman;Verdana;Times;serif;Helvetica;sans-serif';
	config.font_names =
        'Arial/Arial, Helvetica, sans-serif;' +
        'Calibri/Calibri, Verdana, Geneva, sans-serif;' + /* here is your font */
        'Comic Sans MS/Comic Sans MS, cursive;' +
        'Courier New/Courier New, Courier, monospace;' +
        'Georgia/Georgia, serif;' +
        'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
        'Tahoma/Tahoma, Geneva, sans-serif;' +
        'Times New Roman/Times New Roman, Times, serif;' +
        'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
        'Verdana/Verdana, Geneva, sans-serif';
};
