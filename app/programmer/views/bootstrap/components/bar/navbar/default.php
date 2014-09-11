<!-- NavBar -->
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $this->getUrlManager()->getUrl('index', 'site', 'system'); ?>">Trotri</a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav">
<?php echo $this->menus; ?>
      </ul>
      <ul class="nav navbar-nav pull-right">
        <?php if ($this->is_login) : ?>
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->user_name; ?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $this->getUrlManager()->getUrl('cacheclear', 'tools', 'system'); ?>">清理缓存</a></li>
            <li><a href="#">编辑账号</a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $this->getUrlManager()->getUrl('logout', 'site', 'system'); ?>">退出登录</a></li>
          </ul>
        </li>
        <?php endif; ?>
      </ul>
    </div><!-- /.nav-collapse -->
  </div><!-- /.container -->
</div><!-- /.navbar -->
<!-- /NavBar -->