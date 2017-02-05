$(document).ready(function() {
    $(document.getElementById("imageButton")).click(function () {
        $("#imageUpload").slideToggle();
        $("#indexInfo").slideToggle();
        $("#footerButtons").slideToggle();

        document.getElementById("textButton").style.display = "None";
        document.getElementById("imageButton").style.display = "None";
        document.getElementById("creationHeader").style.display = "None";

    });

    $(document.getElementById("textButton")).click(function () {
        $("#addText").slideToggle();
        $("#indexInfo").slideToggle();
        $("#footerButtons").slideToggle();

        document.getElementById("textButton").style.display = "None";
        document.getElementById("imageButton").style.display = "None";
        document.getElementById("creationHeader").style.display = "None";
    });

    $(document.getElementById("back")).click(function () {

        $("#indexInfo").slideToggle();
        $("#footerButtons").slideToggle();

        document.getElementById("imageUpload").style.display = "None";
        document.getElementById("addText").style.display = "None";
        document.getElementById("textButton").style.display = "Inline";
        document.getElementById("imageButton").style.display = "Inline";
        document.getElementById("creationHeader").style.display = "Block";
    });

    $(document.getElementById("hiddenIndex")).click(function(){
        $("#hiddenIndexContent").slideToggle();
        var tagIndex = document.getElementById("hiddenIndex");
        if(tagIndex.innerHTML == "Tags")
        {
            tagIndex.innerHTML = "Hide Tags";
        }
        else
        {
            tagIndex.innerHTML = "Tags";
        }

    });

    $(document.getElementById("fullScreen")).click(function () {

        var fullScreen = document.getElementById("fullScreen");
        if(fullScreen.innerHTML == "Expand")
        {
            fullScreen.innerHTML = "Exit Full Screen";
            document.getElementById("extensionIndex").style.display = "None";
            document.getElementById("listExtensions").style.display = "None";
            document.getElementById("contentSeparator").style.display = "None";
            document.getElementById("contentDetails").style.display = "None";
            document.getElementById("mainContent").style.display = "None";
            $("#createBodyText").attr('rows', '20');
        }
        else
        {
            fullScreen.innerHTML = "Expand";
            $("#createBodyText").attr('rows', '5');
            document.getElementById("extensionIndex").style.display = "Inline";
            document.getElementById("listExtensions").style.display = "Inline";
            document.getElementById("contentSeparator").style.display = "Block";
            document.getElementById("contentDetails").style.display = "Inline";
            document.getElementById("mainContent").style.display = "Block";
        }

    });

});


