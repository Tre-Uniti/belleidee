$(document).ready(function(){
    $(document.getElementById("hiddenIndex")).click(function(){
        $("#hiddenContent").slideToggle();
        var content = document.getElementById("hiddenIndex");
        if(content.innerHTML == "More")
        {
            content.innerHTML = "Less";
        }
        else
        {
            content.innerHTML = "More"
        }

    });
});