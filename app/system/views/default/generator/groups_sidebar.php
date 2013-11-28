<!-- SideBar -->
<div class="col-xs-6 col-sm-2 sidebar-offcanvas" id="sidebar">
  <div class="list-group">
    <a href="<?php echo $this->urls['generator_index']['href']; ?>" class="list-group-item active">
	<?php echo $this->urls['generator_index']['label']; ?>
      <span class="glyphicon glyphicon-plus-sign pull-right" data-toggle="tooltip" data-placement="left" data-original-title="<?php echo $this->urls['generator_index']['label']; ?>" onclick="return Trotri.href('<?php echo $this->urls['generator_create']['href']; ?>');"></span>
    </a>
    <a href="<?php echo $this->urls['generator_trash_index']['href']; ?>" class="list-group-item"><?php echo $this->urls['generator_trash_index']['label']; ?></a>
  </div><!--/.list-group-->
</div><!-- /.col-xs-6 col-sm-2 -->
<!-- /SideBar -->
