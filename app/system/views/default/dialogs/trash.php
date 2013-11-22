<!-- Modal Dialog Trash -->
<div class="modal fade" id="dialog_trash" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <h2 class="text-warning">确定要移至回收站吗？</h2>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="dialog_remove_trash_action">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" onclick="return Core.afterDialogRemoveTrash();">确定</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->
<!-- /Modal Dialog Trash -->
