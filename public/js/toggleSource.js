$(document).ready(function(){
    $(document.getElementById("content")).click(function(){
        $("#hiddenContent").slideToggle();
        var content = document.getElementById("content");
        if(content.innerHTML == "Show Source")
        {
            content.innerHTML = "Hide Source";
        }
        else
        {
            content.innerHTML = "Show Source"
        }

    });
});
