$ ->
  a = -> $("#leftContainer").css("opacity", "0.003") $("#rightContainer").css("opacity", "0.003")
  b = -> $("#leftContainer").css("opacity", "0.90") $("#rightContainer").css("opacity", "0.90")

  $("#centerContent").hover a, b
