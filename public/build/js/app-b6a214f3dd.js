(function() {
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

  $(document).ready(function() {
    $('.hover').bind('touchstart touchend', function(e) {
      e.preventDefault();
      $(this).toggleClass('hover_effect');
    });
  });

}).call(this);

//# sourceMappingURL=app.js.map
