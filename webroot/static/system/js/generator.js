$(document).ready(function() {
  $(":checkbox[name='tbl_profile']").change(function() {
    Generator.modifyTblProfile($(this));
  });

  $(":checkbox[name='column_auto_increment']").change(function() {
    Generator.modifyTblProfile($(this));
  });
});

/**
 * Generator
 * @author songhuan <trotri@yeah.net>
 * @version $Id: generator.js 1 2013-10-16 18:38:00Z $
 */
Generator = {
  /**
   * 编辑“是否生成扩展表”
   * @return void
   */
  modifyTblProfile: function(o) {
    var url = o.parent().parent().attr("href") + "&value=" + o.val();
    Trotri.href(url);
  },

  /**
   * 编辑“是否自动递增”
   * @return void
   */
  modifyColumnAutoIncrement: function(o) {
    var url = o.parent().parent().attr("href") + "&value=" + o.val();
    Trotri.href(url);
  }
}
