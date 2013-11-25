<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Core.href('<?php echo $this->urls['generator_create']['href']; ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    新增生成代码
  </button>
  <button type="button" class="btn btn-default" 
          onclick="return Core.dialogBatchTrash('<?php echo $this->getUrlManager()->getUrl('batchtrash', '', '', array('continue' => $this->getUrlManager()->getRequestUri())); ?>');">
    <span class="glyphicon glyphicon-trash"></span>
    批量放入回收站
  </button>
</form>
