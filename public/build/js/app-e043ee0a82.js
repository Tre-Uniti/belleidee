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

//# sourceMappingURL=app.js.map
