$(document).ready(function() {
  if (g_ctrl == "pictures" && (g_act == "upload")) {
    Core.batchUploadPreviewImg("batch_upload_picture_file");
  }
});

/**
 * System
 * @author songhuan <trotri@yeah.net>
 * @version $Id: system.js 1 2013-10-16 18:38:00Z $
 */
System = {
  textCopy: function(data) {
    if (window.clipboardData) {
      window.clipboardData.clearData();
      window.clipboardData.setData("Text", data);
      alert("已复制到剪贴板");
    }
    else {
      alert("被浏览器拒绝！请使用IE浏览器！");
    }
  }
}
