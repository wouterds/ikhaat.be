var $input = $("#input");
var $urlInput = $('#url');
var $img = $("#image");

$input.keyup(function(e) {
  var val = $input.val();

  if (val.length == 0) {
    val = "ik haat alles!";
  }

  var url = location.protocol + '//' + location.host + '/' + encodeURI(val) + '.jpg';
  $img.attr('src', url);
  $img.attr('alt', val);
  $urlInput.val(url);
});

$urlInput.click(function() {
  $(this).select();
});
