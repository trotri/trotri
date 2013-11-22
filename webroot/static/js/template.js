$(document).ready(function() {
  $(".glyphicon").tooltip();
  $(".icheck").iCheck({
    checkboxClass: "icheckbox_square-blue",
    radioClass: "iradio_square-blue",
    increaseArea: "20%" // optional
  });
  Core.checkedToggle();
  Core.changeSwitchValue();
});

/**
 * Core
 * @author songhuan <trotri@yeah.net>
 * @version $Id: template.js 1 2013-10-16 18:38:00Z $
 */
Core = {
  /**
   * CheckBox全选|全不选，jQuery方式有Bug：全不选后，再全选失败
   * @return void
   */
  checkedToggle: function() {
    var o = Core.getInput("checkbox", "checked_toggle");
    if (o == undefined) {
      return ;
    }
    var a = Core.getInputs("checkbox", o.value);
    o.onclick = function() {
      for (var i in a) {
        a[i].checked = o.checked;
      }
    }
    for (var i in a) {
      a[i].onclick = function() {
        o.checked = (Core.getCheckeds(o.value).length == a.length);
      }
    }
  },

  /**
   * 确认对话框：删除数据时弹出
   * @param string url 删除数据连接
   * @return void
   */
  dialogRemove: function(url) {
    $(":hidden[name='dialog_remove_trash_action']").val(url);
    $("#dialog_remove").modal("show");
  },

  /**
   * 确认对话框：将数据移至回收站时弹出
   * @param string url 将数据移至回收站连接
   * @return void
   */
  dialogTrash: function(url) {
    $(":hidden[name='dialog_remove_trash_action']").val(url);
    $("#dialog_trash").modal("show");
  },

  /**
   * 关闭确认对话框后，提交删除数据链接
   * @return void
   */
  afterDialogRemoveTrash: function() {
    var url = $(":hidden[name='dialog_remove_trash_action']").val();
    Core.href(url);
  },

  /**
   * 展示对话框：Ajax方式展示数据
   * @param string url Ajax请求展示数据连接
   * @param string title 对话框标题
   * @return void
   */
  dialogAjaxView: function(url, title) {
    if (title != undefined) {
      $("#dialog_ajax_view_title").html(title);
    }
    $("#dialog_ajax_view").modal("show");
  },

  /**
   * Alert对话框
   * @param string m Alert消息
   * @param boolean hasErr 是否是错误消息
   * @return void
   */
  dialogAlert: function(m, hasErr, callback) {
    var o = $("#dialog_alert");
    var h = o.find("h2");
    if (hasErr) h.addClass("text-danger");
    h.html(m);
    if (typeof(callback) == "string" && callback != "") {
      o.find(":button").attr("onclick", callback);
    }
    o.modal("show");
  },

  /**
   * 修复开关插件（点击开关插件时，不改变Radio值）
   * @return void
   */
  changeSwitchValue: function() {
    $(".make-switch").each(function() {
      var inputSelector = 'input[type!="hidden"]';
      $(this).find(inputSelector).on("change", function (e, skipOnChange) {
        var o = $(this).parent();
        var v = o.hasClass("switch-on") ? "n" : "y";
        o.find(":checkbox").val(v);
      });
    });
  },

  /**
   * 提交表单
   * @param string type 保存行为类型
   * @param string form 表单名
   * @return void
   */
  formSubmit: function(type, form) {
    var o = $("form" + ((form != undefined) ? "[name='" + form + "']" : ""));
    // 修复开关插件Bug（开关插件在关闭的状态下不传值）
    $(".make-switch > .switch-animate").find(":checkbox").each(function() {
      var e = $(this).parent();
      if (e.hasClass("switch-on")) { $(this).val("y"); }
      else if (e.hasClass("switch-off")) {
        e.append("<input type='hidden' name='" + $(this).attr("name") + "' value='n'>");
      }
    });

    o.attr("action", o.attr("action") + "&do=post&submit_type=" + type);
    o.submit();
  },

  /**
   * 匹配字符串前缀
   * @param string E
   * @param string pre
   * @return boolean
   */
  startWith: function(E, pre) {
    var len = pre.length;
    return E.substr(0, len) == pre;
  },

  /**
   * 获取所有被选中的checkbox框
   * @param string name
   * @return array of object HTMLInputElement
   */
  getCheckeds: function(name) {
    var r = []; var n = 0;
    var a = Core.getInputs("checkbox", name);
    for (var i in a) {
      if (!Core.isInt(i)) {
        continue;
      }
      if (a[i].checked) {
        r[n++] = a[i];
      }
    }
    return r;
  },

  /**
   * 通过类型和名称过滤Input，并获取第一个Input
   * @param string type
   * @param string name
   * @return object HTMLInputElement | undefined
   */
  getInput: function(type, name) {
    var a = Core.getInputs(type, name);
    if (a.length > 0) {
      return a[0];
    }
    return undefined;
  },

  /**
   * 通过类型和名称过滤Input
   * @param string type
   * @param string name
   * @return array of object HTMLInputElement
   */
  getInputs: function(type, name) {
    var r = []; var n = 0;
    var a = document.getElementsByTagName("input");
    for (var i in a) {
      if (!Core.isInt(i)) {
        continue;
      }
      if (type != undefined && a[i].type != type) {
        continue;
      }
      if (name != undefined && a[i].name != name) {
        continue;
      }
      r[n++] = a[i];
    }
    return r;
  },

  /**
   * 判断是否是整数
   * @param integer E
   * @return boolean
   */
  isInt: function(E) {
    var pattern = /^[0-9]+$/ ;
    if (E == "" || !pattern.test(E)) {
      return false;
    }
    return true;
  },

  /**
   * 获取URL
   * @param string act
   * @param string ctrl
   * @param string mod
   * @param array params
   * @return string
   */
  getUrl: function(mod, ctrl, act, params) {
    url = g_url + "?r=" + mod + "/" + ctrl + "/" + act;
    if (typeof(params) == "object") {
      for (var key in params) {
        url += "&" + key + "=" + params[key];
      }
    }
    return url;
  },

  /**
   * 刷新页面
   * @return void
   */
  refresh: function() {
    window.location.href = window.location.href;
  },

  /**
   * 页面跳转
   * @param string url
   * @return void
   */
  href: function(url) {
    window.location.href = url;
    return false;
  },

  search: function(url) {
    window.location.href = url;
    return false;
  }
}
