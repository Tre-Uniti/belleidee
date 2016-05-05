$(document).ready(function(){
    $(document.getElementById("content")).click(function(){
        $("#hiddenContent").slideToggle();
        var content = document.getElementById("content");
        if(content.innerHTML == "Show Source Text")
        {
            content.innerHTML = "Hide Source Text";
        }
        else
        {
            content.innerHTML = "Show Source Text"
        }

    });
});
