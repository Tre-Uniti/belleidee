$ ->
  hide = -> $("#leftContainer").css("opacity", "0.003") $("#rightContainer").css("opacity", "0.003")
  show = -> $("#leftContainer").css("opacity", "0.90") $("#rightContainer").css("opacity", "0.90")
  $("#centerContent").hover hide, show


###
By Osvaldas Valutis, www.osvaldas.info
Available for use under the MIT License
###

(($, window, document) ->

  $.fn.doubleTapToGo = (params) ->
    if !('ontouchstart' of window) and !navigator.msMaxTouchPoints and !navigator.userAgent.toLowerCase().match(/windows phone os 7/i)
      return false
    @each ->
      curItem = false
      $(this).on 'click', (e) ->
        item = $(this)
        if item[0] != curItem[0]
          e.preventDefault()
          curItem = item
        return
      $(document).on 'click touchstart MSPointerDown', (e) ->
        resetItem = true
        parents = $(e.target).parents()
        i = 0
        while i < parents.length
          if parents[i] == curItem[0]
            resetItem = false
          i++
        if resetItem
          curItem = false
        return
      return
    this

  return
) jQuery, window, document




