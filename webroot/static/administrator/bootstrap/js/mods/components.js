$(document).ready(function() {
  if (g_mod == "advert" && g_ctrl == "adverts" && (g_act == "create" || g_act == "modify" || g_act == "view")) {
    Core.uploadPreviewImg("advert_src_file", "advert_src");
    Core.uploadPreviewImg("advert_src2_file", "advert_src2");
    Components.changeAdvertFields();
  }
});

/**
 * Components
 * @author songhuan <trotri@yeah.net>
 * @version $Id: components.js 1 2014-10-22 19:37:00Z $
 */
Components = {
  /**
   * 通过“展现方式”，改变广告字段
   * @return void
   */
  changeAdvertFields: function() {
    var alls = ["show_code", "title", "advert_url", "advert_src", "advert_src_file", "advert_src2", "advert_src2_file", "attr_alt", "attr_width", "attr_height", "attr_fontsize", "attr_target"];

    var data = [];
    data["code"]  = ["show_code"];
    data["text"]  = ["title", "advert_url", "attr_fontsize", "attr_target"];
    data["image"] = ["advert_url", "advert_src", "advert_src_file", "advert_src2", "advert_src2_file", "attr_alt", "attr_width", "attr_height", "attr_target"];
    data["flash"] = ["advert_src", "advert_src_file", "attr_width", "attr_height"];

    var getElement = function(n) {
      if (n == "advert_src_file" || n == "advert_src2_file") {
        return $("#" + n);
      }

      var t = "input";
      if (n == "show_code" || n == "advert_url") {
        t = "textarea";
      }

      return $("#advanced " + t + "[name='" + n + "']");
    };

    var show = function(n) {
      getElement(n).parent().parent().show();
    };

    var hide = function(n) {
      getElement(n).parent().parent().hide();
    };

    var shows = function(a) {
      for (var i in a) {
        show(a[i]);
      }
    };

    var hides = function(a) {
      for (var i in a) {
        hide(a[i]);
      }
    };

    var exec = function() {
      var t = $("#advanced :radio[name='show_type']:checked").val();
      hides(alls);
      shows(data[t]);
    };

    exec();
    $("#advanced :radio[name='show_type']").on('ifChecked', function(event) {
      exec();
    });
  }
}
