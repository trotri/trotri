$(document).ready(function() {
  $(":radio").each(function() {
    var o = $(this);
    if (Core.startWith(o.attr("name"), "tbl_profile")) {
      o.change(function() {
        Generator.ajaxModifyTblProfile(o);
      });
    }
  });
});

/**
 * Generator
 * @author songhuan <trotri@yeah.net>
 * @version $Id: generator.js 1 2013-10-16 18:38:00Z $
 */
Generator = {
  /**
   * Ajax编辑“是否生成扩展表”
   * @return void
   */
  ajaxModifyTblProfile: function(o) {
    var generatorId = o.attr("name").substr(o.attr("name").lastIndexOf("_") + 1);
    if (!Core.isInt(generatorId)) return false;
    var tblProfile = (o.val() == "y") ? "n" : "y";
    var url = Core.getUrl(g_mod, g_ctrl, "ajaxmodify");
    var params = {"tbl_profile" : tblProfile, "id" : generatorId};

    $.getJSON(url, params, function(data) {
      var hasErr = (data.err_no > 0);
      Core.dialogAlert(data.err_msg, hasErr, hasErr ? "Core.refresh();" : "");
    });
  }
}
