<form class="form-horizontal" role="form">

<ul class="nav nav-tabs">
  <li class="active"><a href="#main" data-toggle="tab">主要信息</a></li>
  <li><a href="#profile" data-toggle="tab">扩展信息</a></li>
  <li><a href="#system" data-toggle="tab">系统信息</a></li>
</ul><!-- /.nav nav-tabs -->

<?php include "users_create_form_btns.html.php"; ?>

<div class="tab-content">
  <div class="tab-pane fade active in" id="main">
    <?php include "users_create_form_main.html.php"; ?>
  </div>
  <div class="tab-pane fade" id="profile">
    <?php include "users_create_form_profile.html.php"; ?>
  </div>
  <div class="tab-pane fade" id="system">
    <?php include "users_create_form_system.html.php"; ?>
  </div>
</div><!-- /.tab-content -->

<?php include "users_create_form_btns.html.php"; ?>

</form>
