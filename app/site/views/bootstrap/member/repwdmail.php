<div class="container">

<div class="col-xs-12 col-sm-10">
  <div class="row">
  <?php echo $this->getHtml()->openForm('#', 'post', array('class' => 'form-horizontal', 'id' => 'repwdmail')); ?>

    <h2 class="form-signin-heading"><?php echo $this->MOD_MEMBER_REPWD_MAIL_LABEL; ?><small class="alert"></small></h2>

    <div class="form-group">
      <label class="col-lg-2 control-label"><?php echo $this->MOD_MEMBER_LOGIN_LOGIN_NAME_LABEL; ?></label>
      <div class="col-lg-4">
        <?php echo $this->getHtml()->text('login_name', '', array('class' => 'form-control input-sm')); ?>
      </div>
      <span class="control-label"></span>
    </div>

    <div class="form-group">
      <label class="col-lg-2 control-label"><?php echo $this->MOD_MEMBER_LOGIN_PASSWORD_LABEL; ?></label>
      <div class="col-lg-4">
        <?php echo $this->getHtml()->password('password', '', array('class' => 'form-control input-sm')); ?>
      </div>
      <span class="control-label"></span>
    </div>

    <div class="form-group">
      <label class="col-lg-2 control-label">&nbsp;&nbsp;</label>
      <div class="col-lg-4">
        <?php echo $this->getHtml()->checkbox('remember_me', 1, $this->data['remember_me']); ?> <?php echo $this->MOD_MEMBER_LOGIN_REMEMBER_ME; ?>
      </div>
      <span class="control-label"></span>
    </div>

    <?php echo $this->getHtml()->hidden('http_referer', $this->http_referer); ?>

    <div class="form-group">
      <label class="col-lg-2 control-label">&nbsp;&nbsp;</label>
      <div class="col-lg-4">
        <?php echo $this->getHtml()->button($this->MOD_MEMBER_LOGIN_BUTTON_LOGIN, '', array('class' => 'btn btn-lg btn-primary btn-block', 'onclick' => 'return Member.ajaxLogin();')); ?>
      </div>
    </div>

  <?php echo $this->getHtml()->closeForm(); ?>
  </div>
</div>

</div><!-- /.container -->