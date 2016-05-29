$(document).ready(function(){
    $("form").submit(function(){
        document.getElementById('submit').disabled=true;
        document.getElementById('submit').value='Submitting, please wait...';
    });
});
