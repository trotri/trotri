<!-- NavBar -->
<div class="navbar navbar-fixed-top navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $this->getUrlManager()->getUrl('index', 'site', 'system'); ?>">Trotri</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
<?php echo $this->menus; ?>
      </ul>
      <ul class="nav navbar-nav pull-right">
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">SongHuan <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#">编辑账号</a></li>
            <li class="divider"></li>
            <li><a href="#">退出登录</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.nav-collapse -->
  </div><!-- /.container -->
</div><!-- /.navbar -->
<!-- /NavBar -->
