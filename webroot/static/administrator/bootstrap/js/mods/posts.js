$(document).ready(function() {
  if (g_ctrl == "categories" && (g_act == "create" || g_act == "modify" || g_act == "view")) {
    Posts.toggleJumpUrl();
    $(":checkbox[name='is_jump']").change(function() {
      Posts.toggleJumpUrl($(this).val() == "y" ? "n" : "y");
    });
  }

  if (g_ctrl == "posts" && (g_act == "create" || g_act == "modify" || g_act == "view")) {
    Posts.toggleJumpUrl();
    $(":checkbox[name='is_jump']").change(function() {
      Posts.toggleJumpUrl($(this).val() == "y" ? "n" : "y");
    });

    if (g_act != "view") {
      Core.uploadPreviewImg("picture_file", "picture");
    }
    else {
      Core.uploadPreviewImg("picture_file", "picture", {uploadButtonClass: "ajax-file-upload-gray", url: "", returnType: ""});
    }

    if (g_act == "create") {
      Posts.changeFields();
      $("select[name='module_id']").change(function() {
        Posts.changeFields();
      });
    }
  }
});

/**
 * Posts
 * @author songhuan <trotri@yeah.net>
 * @version $Id: posts.js 1 2013-10-16 18:38:00Z $
 */
Posts = {
  /**
   * 批量开放浏览
   * @param string url
   * @return void
   */
  batchIsPublic: function(url) {
    var n = $(":checkbox[name='checked_toggle']").val();
    var ids = Trotri.getCheckedValues(n);
    if (ids == "") {
      $("#dialog_alert_view_body").html("请选中开放浏览项！");
      $("#dialog_alert").modal("show");
      return ;
    }

    url += "&ids=" + ids + "&column_name=is_public&value=y";
    Trotri.href(url);
  },

  /**
   * 批量改为草稿
   * @param string url
   * @return void
   */
  batchUnIsPublic: function(url) {
    var n = $(":checkbox[name='checked_toggle']").val();
    var ids = Trotri.getCheckedValues(n);
    if (ids == "") {
      $("#dialog_alert_view_body").html("请选中改为草稿项！");
      $("#dialog_alert").modal("show");
      return ;
    }

    url += "&ids=" + ids + "&column_name=is_public&value=n";
    Trotri.href(url);
  },

  /**
   * 显示和隐藏跳转链接
   * @param string isJump
   * @return void
   */
  toggleJumpUrl: function(isJump) {
    if (typeof(isJump) == "undefined") {
      var isJump = $(":checkbox[name='is_jump']").val();
    }

    var jumpUrl = $(":text[name='jump_url']").parent().parent();
    isJump == "y" ? jumpUrl.show() : jumpUrl.hide();
  },

  /**
   * 通过“所属模型”，改变扩展字段
   * @return void
   */
  changeFields: function() {
    var modId = $("select[name='module_id']").val();
    var fields = {};
    for (var id in g_fields) {
      if (modId == id) {
        fields = g_fields[id];
      }
    }

    $("#profile").find(".fields").remove();
    for (var name in fields) {
      var html = "<div class=\"form-group fields\">";
      html += "<label class=\"col-lg-2 control-label\">" + fields[name].label + "</label>";
      html += "<div class=\"col-lg-4\">";
      html += "<textarea class=\"form-control input-sm\" rows=\"5\" name=\"" + name + "\"></textarea>";
      html += "</div>";
      html += "<span class=\"control-label\">" + fields[name].hint + "</span>";
      html += "</div>";
      $("#profile").append(html);
    }
  }
}
