$ ->
  $('#cancel').click ->
    if confirm('Are you sure you want to discard this writing?')
      history.go -1
    else
      false
  false

$ ->
  $('#delete').click ->
    if confirm('Are you sure you want to delete?')
      true
    else
      false
  false


