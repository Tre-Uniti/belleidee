$ ->
  hide = -> $("#leftContainer").css("opacity", "0.003") $("#rightContainer").css("opacity", "0.003")
  show = -> $("#leftContainer").css("opacity", "0.90") $("#rightContainer").css("opacity", "0.90")
  $("#centerContent").hover hide, show

