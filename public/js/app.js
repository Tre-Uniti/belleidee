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
      if (confirm('Are you sure you want to discard this intolerance?')) {
        return true;
      } else {
        return false;
      }
    });
    return false;
  });

  $(function() {
    var hide, show;
    hide = function() {
      return $("#leftContainer").css("opacity", "0.003")($("#rightContainer").css("opacity", "0.003"));
    };
    show = function() {
      return $("#leftContainer").css("opacity", "0.90")($("#rightContainer").css("opacity", "0.90"));
    };
    return $("#centerContent").hover(hide, show);
  });

}).call(this);

//# sourceMappingURL=app.js.map
