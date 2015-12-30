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


  /*
  By Osvaldas Valutis, www.osvaldas.info
  Available for use under the MIT License
   */

  (function($, window, document) {
    $.fn.doubleTapToGo = function(params) {
      if (!('ontouchstart' in window) && !navigator.msMaxTouchPoints && !navigator.userAgent.toLowerCase().match(/windows phone os 7/i)) {
        return false;
      }
      this.each(function() {
        var curItem;
        curItem = false;
        $(this).on('click', function(e) {
          var item;
          item = $(this);
          if (item[0] !== curItem[0]) {
            e.preventDefault();
            curItem = item;
          }
        });
        $(document).on('click touchstart MSPointerDown', function(e) {
          var i, parents, resetItem;
          resetItem = true;
          parents = $(e.target).parents();
          i = 0;
          while (i < parents.length) {
            if (parents[i] === curItem[0]) {
              resetItem = false;
            }
            i++;
          }
          if (resetItem) {
            curItem = false;
          }
        });
      });
      return this;
    };
  })(jQuery, window, document);

}).call(this);

//# sourceMappingURL=app.js.map
