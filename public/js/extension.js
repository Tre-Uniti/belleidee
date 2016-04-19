$(document).ready(function(){
    $(document.getElementById("content")).click(function(){
        $("#hiddenContent").slideToggle();
        var content = document.getElementById("content");
        if(content.innerHTML == "Show Post")
        {
            content.innerHTML = "Hide Post";
        }
        else
        {
            content.innerHTML = "Show Post"
        }

    });
});
