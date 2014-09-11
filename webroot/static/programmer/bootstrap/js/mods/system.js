$(document).ready(function() {
  if (g_ctrl == "site" && g_act == "login") {
    Users.forwardLoginHistory();
  }
});

/**
 * Users
 * @author songhuan <trotri@yeah.net>
 * @version $Id: users.js 1 2013-10-16 18:38:00Z $
 */
Users = {
  /**
   * 登录成功后，跳转到来源页或首页
   * @return void
   */
  forwardLoginHistory: function() {
    if ($("#alert_bar").hasClass("alert-success")) {
      var history = $(":hidden[name='history']").val();
      if (history != "") {
        $("#alert_bar").html($("#alert_bar").text() + "&nbsp;&nbsp;正在跳转...");
        setTimeout(function() {
          location.href = history;
        }, 1000);
      }
    }
  }
}
