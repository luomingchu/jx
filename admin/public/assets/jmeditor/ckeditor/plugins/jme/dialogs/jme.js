CKEDITOR.dialog.add( 'jmeDialog', function( editor ) {
	var jme_fid = "math_frame_" + editor.id ;
    return {
        title: "公式输入",
        minWidth: 500,
        minHeight: 300,
        contents: [
            {
                id: 'tab-basic',
                label: 'Editor',
                elements: [
                    {
                    	//mathquill-editable �ɱ༭
                    	//mathquill-rendered-math �Ѿ���Ⱦ
                    	//mathquill-embedded-latex ֻ����̬��Ⱦ
                        type: 'html',
                        //CKEDITOR.basePath
                        //jmeditor1.0/ckeditor/plugins/jme/dialogs/mathdialog.html
                        html: '<div style="width:500px;height:300px;"><iframe id="' + jme_fid + '" style="width:500px;height:300px;" frameborder="no" src="' + CKEDITOR.basePath + 'plugins/jme/dialogs/mathdialog.html"></iframe></div>'
                    }   
                ]
            }
        ],
        onShow : function(){
        	//$("#jme-math",getIFrameDOM("math_frame")).mathquill("focus");
        },
        onOk: function() {
        	var thedoc = getIFrameDOM(jme_fid);
        	var mathHTML = '<span class="mathquill-rendered-math" style="font-size:' + JMEditor.defaultFontSize + ';" >' + $("#jme-math",thedoc).html() + '</span><span>&nbsp;</span>';
            editor.insertHtml(mathHTML);
					return;			
        }
    };
});

function getIFrameDOM(fid){
	var fm = getIFrame(fid);
	return fm.document||fm.contentDocument;
}
function getIFrame(fid){
	return document.frames ? document.frames[fid] : document.getElementById(fid);
}