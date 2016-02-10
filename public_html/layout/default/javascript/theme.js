
$(".gl-edit").hover(function(){
 $(this).addClass("gl-hover")
},function(){
 if($(this).hasClass("gl-hover")){
 $(this).removeClass("gl-hover")
 }
})

