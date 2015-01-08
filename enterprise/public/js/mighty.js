$(function () {

        $("#nav_list").delegate("span.node-name",{
            "mouseenter":function(){$(this).addClass("hover")},
            "mouseleave":function(){$(this).removeClass("hover")},
            "click":function(event){
                
                if(/click/.test(this.className))
                    return false;
                    
                $(event.delegateTarget).find("span.node-name.click").removeClass("click");
                
                $(this).addClass("click");
                
                var $type = $tcs_resources.find("#resources-type>ul>li.click");
                
                switch($type.attr("type")){
                    case "courseware":
                        // 课件
                        getCourseWare({"page":1});
                        break;
                    case "material":
                        // 素材
                        getMaterial({"page":1});
                        break;
                    case "microlesson":
                        getMicroLesson({"page":1})
                        break;
                    case "teaching":
                        // 授课
                        getTeaching({"page":1});
                        break;
                };
            }
        });







  });


// CKEDITOR.on( 'instanceCreated', function( event ) {
//     var editor = event.editor,
//         element = editor.element;

//     if ( element.is( 'h1', 'h2', 'h3' ) || element.getAttribute( 'id' ) == 'taglist' ) {
//         editor.on( 'configLoaded', function() {

//             editor.config.removePlugins = 'colorbutton,find,flash,font,' +
//                 'forms,iframe,image,newpage,removeformat,' +
//                 'smiley,specialchar,stylescombo,templates';

//             editor.config.toolbarGroups = [
//                 { name: 'editing',      groups: [ 'basicstyles', 'links' ] },
//                 { name: 'undo' },
//                 { name: 'clipboard',    groups: [ 'selection', 'clipboard' ] },
//                 { name: 'about' }
//             ];
//         });
//     }
// });

$(function() {
    $(".lookAnswerBtn").click(function() {
        var a = $(this).parent().parent().find(".ques-anal");
        if (a.css("display") == "none") {
            a.show();
            $(this).html("收起")
        } else {
            a.hide();
            $(this).html("看答案解析")
        }
    })
});
