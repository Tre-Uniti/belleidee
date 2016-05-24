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

});
