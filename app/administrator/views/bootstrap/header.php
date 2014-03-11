<!-- Header -->
<?php echo $this->getHtml()->contentType(); ?>
<?php echo $this->getHtml()->meta('IE=edge', 'X-UA-Compatible', ''); ?>
<?php echo $this->getHtml()->meta('width=device-width, initial-scale=1.0', '', 'viewport'); ?>
<?php echo $this->getHtml()->meta('', '', 'description'); ?>
<?php echo $this->getHtml()->meta('', '', 'author'); ?>
<title>Trotri</title>

<!-- Bootstrap core CSS -->
<?php echo $this->getHtml()->cssFile($this->css_url . '/bootstrap.min.css?v=' . $this->version); ?>
<?php echo $this->getHtml()->cssFile($this->css_url . '/bootstrap-theme.min.css?v=' . $this->version); ?>
<?php echo $this->getHtml()->cssFile($this->js_url . '/bootstrap-switch/bootstrap-switch.css?v=' . $this->version); ?>
<?php echo $this->getHtml()->cssFile($this->js_url . '/jquery-icheck/square-blue.css?v=' . $this->version); ?>

<!-- Custom styles for this template -->
<?php echo $this->getHtml()->cssFile($this->css_url . '/template.css?v=' . $this->version); ?>

<script type="text/javascript">
var g_url = "<?php echo $this->script_url; ?>"; var g_uri = "<?php echo $this->request_uri; ?>"; var g_logId = "<?php echo $this->log_id; ?>";
var g_mod = "<?php echo $this->module; ?>"; var g_ctrl = "<?php echo $this->controller; ?>"; var g_act = "<?php echo $this->action; ?>";
</script>

<?php echo $this->getHtml()->jsFile($this->static_url . '/js/jquery-1.11.0.min.js?v=' . $this->version); ?>

<?php echo $this->getHtml()->jsFile($this->js_url . '/template.js?v=' . $this->version); ?>

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
  <?php echo $this->getHtml()->jsFile($this->js_url . '/assets/html5shiv.js?v=' . $this->version); ?>
  <?php echo $this->getHtml()->jsFile($this->js_url . '/assets/respond.min.js?v=' . $this->version); ?>
<![endif]-->
<!-- /Header -->
