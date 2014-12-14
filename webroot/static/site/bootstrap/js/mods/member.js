$(document).ready(function() {
  Member.bindFocus();
});

/**
 * Member
 * @author songhuan <trotri@yeah.net>
 * @version $Id: member.js 1 2013-10-16 18:38:00Z $
 */
Member = {
  /**
   * 获取会员注册链接
   * @param object params
   * @return string
   */
  getRegUrl: function(params) {
    return Core.getUrl("member", "show", "reg", params);
  },

  /**
   * 获取会员登录链接
   * @param object params
   * @return string
   */
  getLoginUrl: function(params) {
    return Core.getUrl("member", "show", "login", params);
  },

  /**
   * 获取会员退出登录链接
   * @param object params
   * @return string
   */
  getLogoutUrl: function(params) {
    return Core.getUrl("member", "show", "logout", params);
  },

  /**
   * 获取Ajax会员注册链接
   * @param object params
   * @return string
   */
  getAjaxRegUrl: function(params) {
    return Core.getUrl("member", "data", "reg", params) + "&" + new Date().getTime();
  },

  /**
   * 获取Ajax会员登录链接
   * @param object params
   * @return string
   */
  getAjaxLoginUrl: function(params) {
    return Core.getUrl("member", "data", "login", params) + "&" + new Date().getTime();
  },

  /**
   * 获取Ajax通过原始密码重设新密码链接
   * @param object params
   * @return string
   */
  getAjaxRepwdoldpwdUrl: function(params) {
    return Core.getUrl("member", "data", "repwdoldpwd", params) + "&" + new Date().getTime();
  },

  /**
   * 获取Ajax发送找回密码邮件链接
   * @param object params
   * @return string
   */
  getAjaxRepwdsendmailUrl: function(params) {
    return Core.getUrl("member", "data", "repwdsendmail", params) + "&" + new Date().getTime();
  },

  /**
   * @param json 寄存字段名和字段类型
   */
  fields: {
    "login_name"   : ":text",
    "password"     : ":password",
    "repassword"   : ":password",
    "old_pwd"     : ":password",
    "member_mail"  : ":text",
    "remember_me"  : ":checkbox",
    "http_referer" : ":hidden",
  },

  /**
   * 在所有的字段名上绑定得到焦点事件
   * @return void
   */
  bindFocus: function() {
    for (var fieldName in Member.fields) {
      var o = $(Member.fields[fieldName] + "[name='" + fieldName + "']");
      o.focus(function() {
        $(this).parent().parent().removeClass("has-error");
        $(this).parent().next().html($(this).parent().next().attr("title"));
      });
    }
  },

  /**
   * 通过字段名获取字段对象
   * @param string n
   * @param string ID
   * @return object
   */
  getObj: function(n, ID) {
    eval("var type = Member.fields." + n + ";");
    if (typeof(ID) == "undefined") { ID = ""; }

    if (ID != "") {
      if (!Trotri.startWith("#", ID)) { ID = "#" + ID; }
      ID += " ";
    }

    return $(ID + type + "[name='" + n + "']");
  },

  /**
   * 会员注册
   * @return void
   */
  ajaxReg: function() {
    var formId = "register";

    var loginName  = Member.getObj("login_name", formId).val();
    var password   = Member.getObj("password",   formId).val();
    var repassword = Member.getObj("repassword", formId).val();

    $.getJSON(Member.getAjaxRegUrl(), {"login_name": loginName, "password": password, "repassword": repassword}, function(ret) {
      if (ret.err_no > 0) {
        for (var fieldName in ret.data.errors) {
          var o = Member.getObj(fieldName, formId);
          o.parent().parent().addClass("has-error");
          o.parent().next().html(ret.data.errors[fieldName]);
        }
      }
      else {
        $("#" + formId).find(".alert").html(ret.err_msg);
        setTimeout(function() {
          location.href = Member.getLoginUrl({"http_referer" : $(":hidden[name='http_referer']").val()});
        }, 1000);
      }
    });
  },

  /**
   * 会员登录
   * @return void
   */
  ajaxLogin: function() {
    var formId = "login";

    var loginName  = Member.getObj("login_name", formId).val();
    var password   = Member.getObj("password",   formId).val();
    var rememberMe = ($("#" + formId + " :checkbox[name='remember_me']:checked").val() == "1") ? 1 : 0;

    $.getJSON(Member.getAjaxLoginUrl(), {"login_name": loginName, "password": password, "remember_me": rememberMe}, function(ret) {
      $("#" + formId).find(".alert").html(ret.err_msg);
      if (ret.err_no > 0) {
        $("#" + formId).find(".alert").css("color", "#a94442");
      }
      else {
        $("#" + formId).find(".alert").css("color", "");
        setTimeout(function() {
          location.href = $(":hidden[name='http_referer']").val();
        }, 1000);
      }
    });
  },

  /**
   * 通过原始密码重设新密码链接
   * @return void
   */
  ajaxRepwdoldpwd: function() {
    var formId = "repwdoldpwd";

    var oldPwd  = Member.getObj("old_pwd", formId).val();
    var password  = Member.getObj("password", formId).val();
    var repassword  = Member.getObj("repassword", formId).val();

    $.getJSON(Member.getAjaxRepwdoldpwdUrl(), {"old_pwd": oldPwd, "password": password, "repassword": repassword}, function(ret) {
      $("#" + formId).find(".alert").html(ret.err_msg);
      if (ret.err_no > 0) {
        $("#" + formId).find(".alert").css("color", "#a94442");
      }
      else {
        $("#" + formId).find(".alert").css("color", "");
        setTimeout(function() {
          location.href = Member.getLogoutUrl();
        }, 1000);
      }
    });
  },

  /**
   * 发送找回密码邮件
   * @return void
   */
  ajaxRepwdsendmail: function() {
    var formId = "repwdsendmail";
    var o = Member.getObj("member_mail", formId);

    o.focus(function() {
      $("#" + formId).find(".alert").html("");
      $("#" + formId).find(".alert").css("color", "");
    });

    var memberMail  = o.val();

    $.getJSON(Member.getAjaxRepwdsendmailUrl(), {"member_mail": memberMail}, function(ret) {
      $("#" + formId).find(".alert").html(ret.err_msg);
      if (ret.err_no > 0) {
        $("#" + formId).find(".alert").css("color", "#a94442");
      }
      else {
        $("#" + formId).find(".alert").css("color", "");
      }
    });
  }

}
