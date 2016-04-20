$('#image').bind('change', function() {
    alert('This file size is: ' + this.files[0].size/1024/1024 + "MB");
});
