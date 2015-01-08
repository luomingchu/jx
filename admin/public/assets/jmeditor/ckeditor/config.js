/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
	
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		//{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
        //{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
        //{ name: 'styles' },
        //{ name: 'forms' },
		//{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document' ] },
		//{ name: 'others' },
		{ name: 'basicstyles', groups: [ 'basicstyles' ] },
		{ name: 'insert' },
        { name: 'clipboard',   groups: [ 'clipboard' ] },
        //{ name: 'editing',     groups: [ 'find' ] },
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	//config.removeButtons = 'Underline,Subscript,Superscript,SpecialChar';
	config.extraPlugins = 'jme';

    // 图片上传处理方法
    config.filebrowserImageUploadUrl = '../ck-file';

};
