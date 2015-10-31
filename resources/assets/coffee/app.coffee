$ ->
  a = -> $("#leftContainer").css("opacity", "0.02") $("#rightContainer").css("opacity", "0.02")
  b = -> $("#leftContainer").css("opacity", "0.90") $("#rightContainer").css("opacity", "0.90")

  $("#centerContent").hover a, b
