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
   * 批量禁用
   * @param string url
   * @return void
   */
  batchForbidden: function(url) {
    var n = $(":checkbox[name='checked_toggle']").val();
    var ids = Trotri.getCheckedValues(n);
    if (ids == "") {
      $("#dialog_alert_view_body").html("请选中禁用项！");
      $("#dialog_alert").modal("show");
      return ;
    }

    url += "&ids=" + ids + "&column_name=forbidden&value=y";
    Trotri.href(url);
  },

  /**
   * 批量解除禁用
   * @param string url
   * @return void
   */
  batchUnforbidden: function(url) {
    var n = $(":checkbox[name='checked_toggle']").val();
    var ids = Trotri.getCheckedValues(n);
    if (ids == "") {
      $("#dialog_alert_view_body").html("请选中解除禁用项！");
      $("#dialog_alert").modal("show");
      return ;
    }

    url += "&ids=" + ids + "&column_name=forbidden&value=n";
    Trotri.href(url);
  },

  /**
   * 初始化CheckBox全选
   * @return void
   */
  initChecked: function() {
    // 初始化Amcasmodify表单Ctrl全选
    if (g_act == "permissionmodify") {
      var iChecks = [];
      $(".iCheck-helper").each(function() {
        var ipt = $(this).prev(".icheck");
        var n = ipt.attr("name");
        var v = ipt.val();

        if (n == "__mod__[]") {
          iChecks[v] = [];
        }
        else {
          for (var k in iChecks) {
            if (Trotri.startWith(k, n)) {
              iChecks[k][n] = "";
            }
          }
        }
      });

      $(":checkbox[name='__mod__[]']").each(function() {
        var v = $(this).val();
        var b = true;
        for (var k in iChecks[v]) {
          if ($(":checkbox[name='" + k + "']").length != $(":checkbox[name='" + k + "']:checked").length) {
            b = false;
          }
        }

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
    if (g_act == "permissionmodify") {
      var iChecks = [];
      $(".iCheck-helper").each(function() {
        var ipt = $(this).prev(".icheck");
        var n = ipt.attr("name");
        var v = ipt.val();

        if (n == "__mod__[]") {
          iChecks[v] = [];
        }
        else {
          for (var k in iChecks) {
            if (Trotri.startWith(k, n)) {
              iChecks[k][n] = "";
            }
          }
        }
      });

      $(".iCheck-helper").each(function() {
        $(this).click(function() {
          var ipt = $(this).prev(".icheck");
          var n = ipt.attr("name");
          var v = ipt.val();

          if (n == "__mod__[]") {
            var b = $(this).parent().hasClass("checked");
            for (var k in iChecks[v]) {
              $(":checkbox[name='" + k + "']").each(function() {
                $(this).prop("checked", b);
                b ? $(this).parent().addClass("checked") : $(this).parent().removeClass("checked");
              });
            }
          }
          else {
            $(":checkbox[name='__mod__[]']").each(function() {
              var v = $(this).val();
              if (Trotri.startWith(v, n)) {
                var b = true;
                for (var k in iChecks[v]) {
                  if ($(":checkbox[name='" + k + "']").length != $(":checkbox[name='" + k + "']:checked").length) {
                    b = false;
                  }
                }

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
