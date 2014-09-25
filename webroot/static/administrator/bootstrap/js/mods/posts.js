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

    Core.uploadPreviewImg("little_picture_file", "little_picture");
  }
});

/**
 * Posts
 * @author songhuan <trotri@yeah.net>
 * @version $Id: posts.js 1 2013-10-16 18:38:00Z $
 */
Posts = {
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
   * 批量编辑排序
   * @param string url
   * @return void
   */
  batchModifySort: function(url) {
    $(":text").each(function() {
      var name = $(this).attr("name");
      if (name.indexOf("sort") > -1) {
        url += "&" + name + "=" + $(this).val();
      }
    });

    Trotri.href(url);
  }
}
