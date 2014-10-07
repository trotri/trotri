$(document).ready(function() {
  $('[data-toggle=offcanvas]').click(function() {
    $('.row-offcanvas').toggleClass('active');
  });

  $(".glyphicon").tooltip();
  $(".icheck").iCheck({
    checkboxClass: "icheckbox_square-blue",
    radioClass: "iradio_square-blue",
    increaseArea: "20%" // optional
  });
  Core.checkedToggle();
  Core.changeSwitchValue();
  Core.tblSingleModify();
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
   * @return void
   */
  dialogAjaxView: function(url) {
    url += "&" + new Date().getTime();
    $.getJSON(url, function(ret) {
      if (ret.err_no == 0) {
        $("#dialog_ajax_view_title").html(ret.data.title);
        $("#dialog_ajax_view_body").html(ret.data.body);
      }
      else {
        $("#dialog_ajax_view_body").html(ret.err_msg);
      }
    });

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
   * 修复开关插件（点击开关插件时，不改变Checkbox值）
   * @return void
   */
  changeSwitchValue: function() {
    $(".switch").each(function() {
      if ($(this).attr("name") == "label_switch") {
        $(this).on("switch-change", function (e, data) {
          var v = data.value ? "y" : "n";
          $(data.el).val(v);
        });
      }
    });
  },

  /**
   * 提交表单
   * @param object btn  按钮的对象
   * @param string type 按钮的类型
   * @param string lastIndexUrl
   * @return void
   */
  formSubmit: function(btn, type, lastIndexUrl) {
    var o = $(btn).parents("form");

    // 修复开关插件Bug（开关插件在关闭的状态下不传值）
    $(".switch").find(":checkbox").each(function() {
      var e = $(this).parent();
      if (e.hasClass("switch-on")) { $(this).val("y"); }
      else if (e.hasClass("switch-off")) {
        e.append("<input type='hidden' name='" + $(this).attr("name") + "' value='n'>");
      }
    });

    action = o.attr("action") + "&do=post&submit_type=" + type;
    if (lastIndexUrl !== "") {
    	action += "&last_index_url=" + lastIndexUrl;
    }

    o.attr("action", action);
    o.submit();
  },

  /**
   * 编辑单个字段，用于列表页美化版“是|否”选择项表单元素（表单元素需要“tbl_switch='yes'”标示）
   * @return void
   */
  tblSingleModify: function() {
    $(":checkbox").change(function() {
      var o = $(this).parent().parent();
      if (o.attr("tbl_switch") == "yes") {
        var url = o.attr("href");
        if (url != undefined && url.length > 0) {
          url += "&value=" + $(this).val();
          Trotri.href(url);
        }
      }
    });
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
    var url = g_url + "?r=" + mod + "/" + ctrl + "/" + act;
    if (typeof(params) == "object") {
      for (var key in params) {
        url += "&" + key + "=" + params[key];
      }
    }
    return url;
  },

  /**
   * Ajax批量上传并预览图片，基于jquery.uploadfile.js和jquery.form.js开发框架
   * @param string btnId
   * @param string name
   * @param json options
   * @return void
   */
  batchUploadPreviewImg: function(btnId, options) {
    var button = $("#" + btnId);
    var result = []; i = 0;
    var defaults = {
      url: button.attr("url"),
      fileName: button.attr("name"),
      returnType: "JSON",
      allowedTypes: "jpg,gif,png,bmp",
      multiple: true,
      dragDrop: true,
      showDone: false,
      showAbort: false,
      showFileCounter: false,
      showProgress: true,
      showQueueDiv: false,
      showPreview: false,
      uploadButtonClass: "ajax-file-upload-green",
      dragDropStr: "<span><b>Drag &amp; Drop Files</b></span>",
      statusBarWidth: "100%",
      dragdropWidth: "99.8%",
      previewHeight: "300px",
      previewWidth: "300px",
      onLoad: function (obj) {},
      onSubmit: function(files, xhr) {},
      onSuccess: function(files, response, xhr, pd) {
        result[i++] = response;
      },
      afterUploadAll: function() {
        for (var i in result) {
          var oby = parseInt(i) + 1;
          if (result[i].err_no == 0) {
            $(".ajax-file-upload-preview").eq(i).attr("src", result[i].data.url);
            $(".ajax-file-upload-filename").eq(i).text(oby + "：" + result[i].data.file_name);
          }
          else {
            $(".ajax-file-upload-filename").eq(i).text(oby + "：" + result[i].err_msg);
          }
        }

        $(".ajax-file-upload-preview").show();
        $(".ajax-file-upload-preview").each(function() { if ($(this).attr("src") == undefined) { $(this).hide(); } });
      },
      onError: function(files, status, message, pd) {},
      onCancel: function(files, pd) {}
    };

    $.extend(defaults, options);
    button.uploadFile(defaults);
  }
}