$(document).ready(function() {
  $(":checkbox[name='tbl_profile']").change(function() {
    Generator.ajaxModifyTblProfile($(this));
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
    var id = o.parent().parent().attr("id");
    var generatorId = id.substr(id.lastIndexOf("_") + 1);
    if (!Core.isInt(generatorId)) return false;
    var tblProfile = o.val();
    var url = Core.getUrl(g_mod, g_ctrl, "ajaxmodify");
    var params = {"tbl_profile" : tblProfile, "id" : generatorId};

    $.getJSON(url, params, function(data) {
      var hasErr = (data.err_no > 0);
      Core.dialogAlert(data.err_msg, hasErr, hasErr ? "Core.refresh();" : "");
    });
  }
}
