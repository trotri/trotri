$(document).ready(function() {
  Ucenter.checkedToggle(); 
});

/**
 * Ucenter
 * @author songhuan <trotri@yeah.net>
 * @version $Id: ucenter.js 1 2014-01-25 18:38:00Z $
 */
Ucenter = {
  /**
   * Ctrl CheckBox全选|全不选，jQuery方式有Bug：全不选后，再全选失败
   * @return void
   */
  checkedToggle: function() {
    $("form[name='amcasmodify']").find(".iCheck-helper").each(function() {
      $(this).click(function() {
        var ipt = $(this).prev(".icheck");
        var n = ipt.attr("name");
        var v = ipt.val();
        var b = $(this).parent().hasClass("checked");
        if (n == "__ctrl__[]") {
          alert(v);
        }
      });
    });
  },
}
