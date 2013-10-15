$(document).ready(function() {
  $(".glyphicon").tooltip();
  $(".icheck").iCheck({
    checkboxClass: "icheckbox_square-blue",
    radioClass: "iradio_square-blue",
    increaseArea: "20%" // optional
  });
});

Core = {
  href: function(sUrl) {
    window.location.href = sUrl;
    return false;
  },
  search: function(sUrl) {
    window.location.href = sUrl;
    return false;
  }
}
