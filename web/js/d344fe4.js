$(function(){
    window.console.log($(".ballsCheckBox"));
    $("form").addClass("form-inline");
    $(".ballsCheckBox").addClass("form-control").unwrap();
    $checkboxes = $(".ballsCheckBox");
    
    /** batch(5)**/
    $checkboxes.each(function(k, v){
        window.console.log(k);
        if((k+1)%5 == 0){
            $(this).after("<br />");
        }        
    })
    
})

