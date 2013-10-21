<!-- Modal Dialog Remove -->
<div class="modal fade" id="dialog_remove" tabindex="-1" role="dialog" aria-labelledby="dialog_remove_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h2 class="text-danger">删除后将无法恢复，确定要删除吗？</h2>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="dialog_remove_trash_action">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="return Core.ajaxRemoveTrash();">确定</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->
<!-- /Modal Dialog Remove -->
