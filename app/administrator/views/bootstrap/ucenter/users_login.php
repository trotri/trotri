<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
  <head>
<?php $this->display('header'); ?>
<?php echo $this->getHtml()->cssFile($this->css_url . '/signin.css?v=' . $this->version); ?>
  </head>
<style>

</style>
  <body>

<?php $this->widget('views\bootstrap\components\bar\AlertBar'); ?>

<div class="container">

<form class="form-signin" method="post" action="<?php echo $this->getUrlManager()->getUrl($this->action); ?>">
  <h2 class="form-signin-heading"><?php echo $this->CFG_SYSTEM_URLS_ADMINISTRATOR; ?></h2>
  <input type="text" name="login_name" class="form-control" placeholder="<?php echo $this->CFG_SYSTEM_GLOBAL_LOGIN_NAME; ?>" required autofocus>
  <input type="password" name="password" class="form-control" placeholder="<?php echo $this->CFG_SYSTEM_GLOBAL_LOGIN_PASSWORD; ?>" required>
  <label class="checkbox">
  <input type="checkbox" name="remember_me" value="1"> <?php echo $this->CFG_SYSTEM_GLOBAL_REMEMBER_ME; ?></label>
  <button class="btn btn-lg btn-primary btn-block" type="submit"><?php echo $this->CFG_SYSTEM_GLOBAL_LOGIN; ?></button>
</form>

</div><!-- /.container -->

<?php $this->display('scripts'); ?>

  </body>
</html>