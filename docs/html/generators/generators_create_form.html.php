<form class="form-horizontal" role="form">

<ul class="nav nav-tabs">
  <li class="active"><a href="#main" data-toggle="tab">主要信息</a></li>
  <li><a href="#act" data-toggle="tab">行动名</a></li>
  <li><a href="#system" data-toggle="tab">系统信息</a></li>
</ul><!-- /.nav nav-tabs -->

<?php include "generators_create_form_btns.html.php"; ?>

<div class="tab-content">
  <div class="tab-pane fade active in" id="main">
    <?php include "generators_create_form_main.html.php"; ?>
  </div>
  <div class="tab-pane fade" id="act">
    <?php include "generators_create_form_act.html.php"; ?>
  </div>
  <div class="tab-pane fade" id="system">
    <?php include "generators_create_form_system.html.php"; ?>
  </div>
</div><!-- /.tab-content -->

<?php include "generators_create_form_btns.html.php"; ?>

</form>
