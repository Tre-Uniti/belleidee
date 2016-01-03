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

}).call(this);

//# sourceMappingURL=app.js.map
