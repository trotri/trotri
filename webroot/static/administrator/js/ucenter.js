$(document).ready(function() {
  Ucenter.initChecked();
  Ucenter.checkedToggle();
});

/**
 * Ucenter
 * @author songhuan <trotri@yeah.net>
 * @version $Id: ucenter.js 1 2014-01-25 18:38:00Z $
 */
Ucenter = {
  /**
   * 初始化CheckBox全选
   * @return void
   */
  initChecked: function() {
    // 初始化Amcasmodify表单Ctrl全选
    if (g_act == "amcasmodify") {
      $(":checkbox[name='__ctrl__[]']").each(function() {
        var v = $(this).val();
        var b = ($(":checkbox[name='" + v + "']").length == $(":checkbox[name='" + v + "']:checked").length);
        $(this).prop("checked", b);
        b ? $(this).parent().addClass("checked") : $(this).parent().removeClass("checked");
      });
    }
  },

  /**
   * CheckBox全选|全不选
   * @return void
   */
  checkedToggle: function() {
    // Amcasmodify表单全选
    if (g_act == "amcasmodify") {
      $(".iCheck-helper").each(function() {
        $(this).click(function() {
          var ipt = $(this).prev(".icheck");
          var n = ipt.attr("name");
          var v = ipt.val();
          if (n == "__ctrl__[]") {
            var b = $(this).parent().hasClass("checked");
            $(":checkbox[name='" + v + "']").each(function() {
              $(this).prop("checked", b);
              b ? $(this).parent().addClass("checked") : $(this).parent().removeClass("checked");
            });
          }
          else {
            var b = ($(":checkbox[name='" + n + "']").length == $(":checkbox[name='" + n + "']:checked").length);
            $(":checkbox[name='__ctrl__[]']").each(function() {
              if ($(this).val() == n) {
                $(this).prop("checked", b);
                b ? $(this).parent().addClass("checked") : $(this).parent().removeClass("checked");
              }
            });
          }
        });
      });
    }
  }
}
