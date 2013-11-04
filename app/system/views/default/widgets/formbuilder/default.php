<!-- FormBuilder -->
<?php echo $this->openForm; ?>

<ul class="nav nav-tabs">
  <?php echo $this->tabRender; ?>
</ul><!-- /.nav nav-tabs -->

<div class="form-group">
  <div class="col-lg-1"></div>
  <div class="col-lg-11"><?php echo $this->buttonRender; ?></div>
</div><!-- /.form-group -->

<div class="tab-content">
<?php echo $this->inputRender; ?>
</div><!-- /.tab-content -->

<div class="form-group">
  <div class="col-lg-1"></div>
  <div class="col-lg-11"><?php echo $this->buttonRender; ?></div>
</div><!-- /.form-group -->

<?php echo $this->closeForm; ?>
<!-- /FormBuilder -->
