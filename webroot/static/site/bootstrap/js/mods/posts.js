$(document).ready(function() {
});

/**
 * Posts
 * @author songhuan <trotri@yeah.net>
 * @version $Id: posts.js 1 2013-10-16 18:38:00Z $
 */
Posts = {
  /**
   * 获取评论HTML
   * @param json row
   * @param boolean hasResp
   * @param string respLabel
   * @return string
   */
  getCommentDom: function(row, hasResp, respLabel) {
    var string = '<blockquote id="comm_view_' + row.comment_id + '">';
    string += '<p>' + row.content + '</p>';
    string += '<p class="blog-post-meta">' + row.dt_last_modified + ' by ' + row.author_name + '</p>';
    if (hasResp) {
      string += '<p id="comm_reply_' + row.comment_id + '"><a href="javascript: Posts.moveComment(\'' + row.comment_id + '\');">' + respLabel + '</a></p>';	
    }
    string += '</blockquote>';
    return string;
  },

  moveComment: function(commId) {
    var response = $("#comm_response");
    var remove = $(".comm-response-remove-reply");
    var commentPid = $("#comm_response :hidden[name='comment_pid']");

    commentPid.val(commId);
    response.insertAfter("#comm_reply_" + commId);
    remove.show();

    remove.click(function() {
      $(this).hide();
      commentPid.val(0);
      response.insertAfter("#comm_response_reference");
    });
  }
}
