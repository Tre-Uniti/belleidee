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
        var content = document.getElementById("hiddenIndex");
        if(content.innerHTML == "Show Tags")
        {
            content.innerHTML = "Hide Tags";
        }
        else
        {
            content.innerHTML = "Show Tags"
        }

    });

});
//Function for pictures
//<![CDATA[
(function (w, d) {
    if (!w.Pikiz || (w.Pikiz && typeof w.Pikiz.init !== "function") ) {
        var s = d.createElement("script");
        var g = d.getElementsByTagName("script")[0];
        s.addEventListener("load", function () {
            w.Pikiz.init("9913fcaf-93bf-4550-b917-b2e3e740ece0", {"appUrl":"https://app.getpikiz.com","style":"orange","position":"topLeft","size":"default","hover":false,"language":"en"});
        });
        s.async = true;
        s.src="https://app.getpikiz.com/scripts/embed/pikiz.js";
        g.parentNode.insertBefore(s,g);
    }
})(window, document);
//]]>


