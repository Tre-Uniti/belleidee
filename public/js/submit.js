$(document).ready(function(){
    $("form").submit(function(){
        document.getElementById('submit').disabled=true;
        document.getElementById('submit').value='Submitting, please wait';
    });
    (function() {
        $(function() {
            $('#cancel').click(function() {
                if (confirm('Are you sure you want to discard this writing?')) {
                    return history.go(-1);
                } else {
                    return false;
                }
            });
            return false;
        });

        $(function() {
            $('#delete').click(function() {
                if (confirm('Are you sure you want to delete?')) {
                    return true;
                } else {
                    return false;
                }
            });
            return false;
        });

    }).call(this);
});
