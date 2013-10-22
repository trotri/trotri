<form class="form-horizontal" method="post" name="create" action="<?php echo $this->util->getUrlByAct(); ?>">

<ul class="nav nav-tabs">
  <li class="active"><a href="#main" data-toggle="tab">主要信息</a></li>
  <li><a href="#act" data-toggle="tab">行动名</a></li>
  <li><a href="#system" data-toggle="tab">系统信息</a></li>
</ul><!-- /.nav nav-tabs -->

<?php $this->display('generator/index_create_btns'); ?>

<div class="tab-content">
  <div class="tab-pane fade active in" id="main">
    <?php $this->display('generator/index_create_main'); ?>
  </div>
  <div class="tab-pane fade" id="act">
    <?php $this->display('generator/index_create_act'); ?>
  </div>
  <div class="tab-pane fade" id="system">
    <?php $this->display('generator/index_create_system'); ?>
  </div>
</div><!-- /.tab-content -->

<?php $this->display('generator/index_create_btns'); ?>

</form>
