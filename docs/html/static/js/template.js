$(document).ready(function() {
  $(".glyphicon").tooltip();
  $(".icheck").iCheck({
    checkboxClass: "icheckbox_square-blue",
    radioClass: "iradio_square-blue",
    increaseArea: "20%" // optional
  });
});

Core = {
  /**
   * 确认对话框：删除数据时弹出
   * @param string sUrl 删除数据连接
   * @return void
   */
  dialogRemove: function(sUrl) {
    $(":hidden[name='dialog_remove_trash_action']").val(sUrl);
    $("#dialog_remove").modal("show");
  },

  /**
   * 确认对话框：将数据移至回收站时弹出
   * @param string sUrl 将数据移至回收站连接
   * @return void
   */
  dialogTrash: function(sUrl) {
    $(":hidden[name='dialog_remove_trash_action']").val(sUrl);
    $("#dialog_trash").modal("show");
  },

  /**
   * Ajax方式删除数据
   * @return void
   */
  ajaxRemoveTrash: function() {
    var sUrl = $(":hidden[name='dialog_remove_trash_action']").val();
    alert(sUrl);
  },

  /**
   * 展示对话框：Ajax方式展示数据
   * @param string sUrl Ajax请求展示数据连接
   * @param string sTitle 对话框标题
   * @return void
   */
  dialogAjaxView: function(sUrl, sTitle) {
    if (sTitle != undefined) {
      $("#dialog_ajax_view_title").html(sTitle);
    }

    $("#dialog_ajax_view").modal("show");
  },

  href: function(sUrl) {
    window.location.href = sUrl;
    return false;
  },
  search: function(sUrl) {
    window.location.href = sUrl;
    return false;
  }
}
