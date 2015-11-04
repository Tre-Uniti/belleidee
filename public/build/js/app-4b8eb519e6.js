(function() {
  $(function() {
    var a, b;
    a = function() {
      return $("#leftContainer").css("opacity", "0.003")($("#rightContainer").css("opacity", "0.003"));
    };
    b = function() {
      return $("#leftContainer").css("opacity", "0.90")($("#rightContainer").css("opacity", "0.90"));
    };
    return $("#centerContent").hover(a, b);
  });

}).call(this);

//# sourceMappingURL=app.js.map
