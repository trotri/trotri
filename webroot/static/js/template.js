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
    var o = Trotri.getInput("checkbox", "checked_toggle");
    if (o == undefined) { return ; }
    var a = Trotri.getInputs("checkbox", o.value);
    o.onclick = function() {
      for (var i in a) {
        a[i].checked = o.checked;
      }
    }
    for (var i in a) {
      a[i].onclick = function() {
        o.checked = (Trotri.getCheckeds(o.value).length == a.length);
      }
    }
  },

  /**
   * 确认对话框：删除数据时弹出
   * @param string url 删除数据链接
   * @return void
   */
  dialogRemove: function(url) {
    Core._dialogBatchTrash(url, false, false);
  },

  /**
   * 确认对话框：将数据移至回收站时弹出
   * @param string url 将数据移至回收站链接
   * @return void
   */
  dialogTrash: function(url) {
    Core._dialogBatchTrash(url, true, false);
  },

  /**
   * 确认对话框：批量删除数据时弹出
   * @param string url 批量删除数据链接
   * @return void
   */
  dialogBatchRemove: function(url) {
    Core._dialogBatchTrash(url, false, true);
  },

  /**
   * 确认对话框：将数据批量移至回收站时弹出
   * @param string url 将数据批量移至回收站链接
   * @return void
   */
  dialogBatchTrash: function(url) {
    Core._dialogBatchTrash(url, true, true);
  },

  /**
   * 确认对话框：删除或移至回收站时弹出
   * @param string url
   * @param boolean isTrash
   * @param boolean isBatch
   * @return void
   */
  _dialogBatchTrash: function(url, isTrash, isBatch) {
    $(":hidden[name='dialog_trash_remove_url']").val(url);
    if (isTrash) {
      $("#dialog_trash_remove_view_body").html("确定要移至回收站吗？");
      $("#dialog_trash_remove_view_body").addClass("text-warning").removeClass("text-danger");
    }
    else {
      $("#dialog_trash_remove_view_body").html("确定要删除吗？删除后将无法恢复！");
      $("#dialog_trash_remove_view_body").addClass("text-danger").removeClass("text-warning");
    }

    $(":hidden[name='dialog_trash_remove_is_batch']").val(isBatch ? "1" : "0");
    var ids = "";
    if (isBatch) {
      var n = $(":checkbox[name='checked_toggle']").val();
      var ids = Trotri.getCheckedValues(n);
      if (ids == "") { $("#dialog_trash_remove_view_body").html("请选中删除项！"); }
    }
    $(":hidden[name='dialog_trash_remove_ids']").val(ids);
    $("#dialog_trash_remove").modal("show");
  },

  /**
   * 关闭确认对话框后，提交到删除或移至回收站的链接
   * @return void
   */
  afterDialogTrashRemove: function() {
    var url = $(":hidden[name='dialog_trash_remove_url']").val();
    var isBatch = $(":hidden[name='dialog_trash_remove_is_batch']").val();
    var ids = $(":hidden[name='dialog_trash_remove_ids']").val();
    if (isBatch == "0") { Trotri.href(url); return ; }
    if (ids == "") { $("#dialog_trash_remove").modal("hide"); return ; }
    url += "&ids=" + ids;
    Trotri.href(url);
  },

  /**
   * 批量还原数据
   * @return void
   */
  batchRestore: function(url) {
    var n = $(":checkbox[name='checked_toggle']").val();
    var ids = Trotri.getCheckedValues(n);
    if (ids == "") { Core.dialogAlert("请选中还原项！"); return ""; }
    url += "&ids=" + ids;
    Trotri.href(url);
  },

  /**
   * 展示对话框：Ajax方式展示数据
   * @param string url Ajax请求展示数据链接
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
   * @param object btn  按钮的对象
   * @param string type 按钮的类型
   * @param string httpReferer
   * @return void
   */
  formSubmit: function(btn, type, httpReferer) {
    var o = $(btn).parents("form");

    // 修复开关插件Bug（开关插件在关闭的状态下不传值）
    $(".make-switch > .switch-animate").find(":checkbox").each(function() {
      var e = $(this).parent();
      if (e.hasClass("switch-on")) { $(this).val("y"); }
      else if (e.hasClass("switch-off")) {
        e.append("<input type='hidden' name='" + $(this).attr("name") + "' value='n'>");
      }
    });

    action = o.attr("action") + "&do=post&submit_type=" + type;
    if (httpReferer !== "") {
    	action += "&http_referer=" + httpReferer;
    }

    o.attr("action", action);
    o.submit();
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
}
