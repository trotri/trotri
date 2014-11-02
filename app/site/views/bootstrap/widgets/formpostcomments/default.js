<script type="text/javascript">
$("#<?php echo $this->id; ?> :button[name='_button_save_']").click(function() {
  var getObj = function(E, n) {
    return $("#<?php echo $this->id; ?> " + E + "[name='" + n + "']");
  };

  var getAct = function() {
    return $("#<?php echo $this->id; ?>").attr("action"); 
  };

  var hasErr = function(obj) {
    return obj.parent().parent().hasClass("has-error");
  };

  var addErr = function(obj) {
    obj.parent().parent().addClass("has-error");
  };

  var removeErr = function(obj) {
    obj.parent().parent().removeClass("has-error");
  };

  var oAuthorName = getObj("input", "author_name");
  var oAuthorMail = getObj("input", "author_mail");
  var oContent = getObj("textarea", "content");
  var oCommentPid = getObj("input", "comment_pid");

  var objs = [oAuthorName, oAuthorMail, oContent];
  for (var i in objs) {
    objs[i].val() == '' ? addErr(objs[i]) : removeErr(objs[i]);
  }

  Trotri.isMail(oAuthorMail.val()) ? removeErr(oAuthorMail) : addErr(oAuthorMail);

  var isSubmit = function() {
    for (var i in objs) {
      if (hasErr(objs[i])) { return false; }
    }

    return true;
  };

  if (!isSubmit()) {
    return ;
  }

  var isPublish = <?php echo $this->isPublish; ?>;

  $.getJSON(
    getAct() + "&" + new Date().getTime(),
    {
      "author_name": oAuthorName.val(),
      "author_mail": oAuthorMail.val(),
      "content": oContent.val(),
      "post_id": getObj("input", "post_id").val(),
      "comment_pid": oCommentPid.val(),
    },
    function(ret) {
      if (ret.err_no == 0) {
        var content = isPublish ? oContent.val() : "<?php echo $this->auditing; ?>";
        var row = {
          "author_name": oAuthorName.val(),
          "content": content,
          "dt_last_modified": "<?php echo $this->just_now; ?>",
          "comment_id": ret.data.id,
        };

        if (oCommentPid.val() > 0) {
          $("#comm_reply_" + oCommentPid.val()).after(Posts.getCommentDom(row, false, "<?php echo $this->response; ?>"));
        }
        else {
          $("#post_comments_box").prepend(Posts.getCommentDom(row, false, "<?php echo $this->response; ?>"));
        }

        oAuthorName.val("");
        oAuthorMail.val("");
        oContent.val("");
      }
    }
  );
});
</script>