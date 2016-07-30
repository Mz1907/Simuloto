$(function(){
    //window.console.log($(".ballsCheckBox"));
    //$("form").addClass("form-inline");
    //$checkboxes = $(".ballsCheckBox");
    
    
    /** apply  **/
    $(":checkbox").each(function(k, v){
        $(this).bootstrapToggle({
            on: (k+1),
            off: (k+1),
            onstyle: "success",
            offstyle: "danger",            
        })
    })
    
    $(".ios").css({
        "border-radius": "25px"
    })
})

