<script type="text/javascript">
function loadComments(paged) {
  $.getJSON("<?php echo $this->url; ?>&" + new Date().getTime(), {"postid": <?php echo $this->postid; ?>, "paged": paged}, function(ret) {
    var obj = $("#<?php echo $this->id; ?>");
    obj.empty();
    var respLabel = "<?php echo $this->response; ?>";
    if (ret.err_no == 0) {
      var data = ret.data;
      var rows = data.rows;
      for (var i in rows) {
        obj.append(Posts.getCommentDom(rows[i], true, respLabel));
        var sub = $("#comm_view_" + rows[i].comment_id);
        if (typeof(rows[i].data) == "object") {
          for (var j in rows[i].data) {
            sub.append(Posts.getCommentDom(rows[i].data[j], true, respLabel));
            var subsub = $("#comm_view_" + rows[i].data[j].comment_id);
            for (var z in rows[i].data[j].data) {
              subsub.append(Posts.getCommentDom(rows[i].data[j].data[z], false, respLabel)); 
            }
          }
        }
      }
    }

    var paginator = Core.getPaginator("loadComments", data.paged, data.total, data.limit);
    obj.append(paginator);
  });
}

$(document).ready(function() {
  loadComments(1);
});
</script>