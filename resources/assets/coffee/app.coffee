$ ->
  $('#cancel').click ->
    if confirm('Are you sure you want to discard this writing?')
      history.go -1
    else
      false
  false

$ ->
  hide = -> $("#leftContainer").css("opacity", "0.003") $("#rightContainer").css("opacity", "0.003")
  show = -> $("#leftContainer").css("opacity", "0.90") $("#rightContainer").css("opacity", "0.90")
  $("#centerContent").hover hide, show




