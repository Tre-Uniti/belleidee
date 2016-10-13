$(document).ready(function(){
    $(document.getElementById("content")).click(function(){
        $("#hiddenContent").slideToggle();
        var content = document.getElementById("content");
        if(content.innerHTML != "Hide Source")
        {
            content.innerHTML = "Hide Source";
        }
        else
        {
            content.innerHTML = "Show Source"
        }

    });

    //Show or Hide other extensions
    $(document.getElementById("extensionIndex")).click(function(){
        $("#otherExtensions").slideToggle();
        var content = document.getElementById("extensionIndex");
        if(content.innerHTML == "Show Extensions")
        {
            content.innerHTML = "Hide Extensions";
        }
        else
        {
            content.innerHTML = "Show Extensions"
        }

    });

    //Show or Hide Manager Options
    $(document.getElementById("managerOptions")).click(function(){
        $("#hiddenManagerOptions").slideToggle();
        var content = document.getElementById("managerOptions");
        if(content.innerHTML == "Show Manager Options")
        {
            content.innerHTML = "Hide Manager Options";
        }
        else
        {
            content.innerHTML = "Show Manager Options"
        }

    });
});
