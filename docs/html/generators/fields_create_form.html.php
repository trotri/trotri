<form class="form-horizontal" role="form">

<ul class="nav nav-tabs">
  <li class="active"><a href="#main" data-toggle="tab">主要信息</a></li>
  <li><a href="#html" data-toggle="tab">HTML展示</a></li>
  <li><a href="#validator" data-toggle="tab">验证规则</a></li>
</ul><!-- /.nav nav-tabs -->

<?php include "fields_create_form_btns.html.php"; ?>

<div class="tab-content">
  <div class="tab-pane fade active in" id="main">
    <?php include "fields_create_form_main.html.php"; ?>
  </div>
  <div class="tab-pane fade" id="html">
    <?php include "fields_create_form_html.html.php"; ?>
  </div>
  <div class="tab-pane fade" id="validator">
    <?php include "fields_create_form_validator.html.php"; ?>
  </div>
</div><!-- /.tab-content -->

<?php include "fields_create_form_btns.html.php"; ?>

</form>
