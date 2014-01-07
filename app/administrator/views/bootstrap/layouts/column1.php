<!DOCTYPE html>
<html lang="zh-CN">
  <head>
<?php $this->display('header'); ?>
  </head>

  <body>

<?php $this->widget('components\NavBar'); ?>

<div class="container">

<?php echo $this->layoutContent; ?>

</div><!-- /.container -->

<?php $this->display('scripts'); ?>

  </body>
</html>