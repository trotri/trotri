$(document).ready(function() {
  $(".glyphicon").tooltip();
  $(".icheck").iCheck({
    checkboxClass: "icheckbox_square-blue",
    radioClass: "iradio_square-blue",
    increaseArea: "20%" // optional
  });
  Core.checkedToggle();
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
   * Ajax方式删除数据
   * @return void
   */
  ajaxRemoveTrash: function() {
    var url = $(":hidden[name='dialog_remove_trash_action']").val();
    alert(url);
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
   * 提交表单
   * @param string form 表单名
   * @param string type 保存行为类型 
   * @return void
   */
  formSubmit: function(type, form) {
    var types = ["save", "save2index", "save2create"];
    if ($.inArray(type, types) < 0) {
      type = "save";
    }

    // 修复开关插件Bug（开关插件在关闭的状态下不传值）
    var o = $("form" + ((form != undefined) ? "[name='" + form + "']" : ""));
    $(".make-switch > .switch-animate").find("input[type='radio']").each(function() {
      if ($(this).parent().hasClass("switch-on")) {
        $("input[name='" + $(this).attr("name") + "']").val("y");
      }
      else if ($(this).parent().hasClass("switch-off")) {
        o.append("<input type='hidden' name='" + $(this).attr("name") + "' value='n'>")
      }
    });

    o.attr("action", o.attr("action") + "&do=post&submit_type=" + type);
    o.submit();
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
