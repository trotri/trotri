<!-- NavBar -->
<div class="navbar navbar-fixed-top navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $this->index['href']; ?>">Trotri</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="dropdown active">
        <a href="<?php echo $this->generator_index['href']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->generator_index['label']; ?> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo $this->generator_index['href']; ?>"><?php echo $this->generator_index['label']; ?></a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $this->generator_create['href']; ?>"><?php echo $this->generator_create['label']; ?></a></li>
            <li class="divider"></li>
            <li><a href="<?php echo $this->generator_trash_index['href']; ?>"><?php echo $this->generator_trash_index['label']; ?></a></li>
          </ul>
        </li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
      </ul>
      <ul class="nav navbar-nav pull-right">
        <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">SongHuan <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#">退出登录</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.nav-collapse -->
  </div><!-- /.container -->
</div><!-- /.navbar -->
<!-- /NavBar -->
