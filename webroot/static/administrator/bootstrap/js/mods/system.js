$(document).ready(function() {
});

/**
 * System
 * @author songhuan <trotri@yeah.net>
 * @version $Id: system.js 1 2013-10-16 18:38:00Z $
 */
System = {
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
  },
  textCopy: function(data) {
    if (window.clipboardData) {
      window.clipboardData.clearData();
      window.clipboardData.setData("Text", data);
      alert("已复制到剪贴板");
    }
    else {
      alert("被浏览器拒绝！请使用IE浏览器！");
    }
  }
}
