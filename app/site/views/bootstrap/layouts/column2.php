<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
  <head>
<?php $this->display('header'); ?>
  </head>

  <body>
<?php $this->widget('components\menus\NavBar'); ?>

<div class="container">

  <div class="blog-header">
<?php if (isset($this->beforeLayoutContent)) { echo $this->beforeLayoutContent; } ?>
  </div>

  <div class="row">

    <div class="col-sm-9 blog-main">
<?php echo $this->layoutContent; ?>
    </div><!-- /.blog-main -->

<?php $this->display($this->sidebar); ?>
  </div>

</div><!-- /.container -->

<?php $this->display('footer'); ?>
<?php $this->display('scripts'); ?>

  </body>
</html>