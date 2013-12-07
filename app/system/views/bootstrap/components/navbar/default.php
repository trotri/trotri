<!-- NavBar -->
<div class="navbar navbar-fixed-top navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo $this->getUrlManager()->getUrl('index', 'index', 'generator'); ?>">Trotri</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
<?php echo $this->menus; ?>
      </ul>
    </div><!-- /.nav-collapse -->
  </div><!-- /.container -->
</div><!-- /.navbar -->
<!-- /NavBar -->
