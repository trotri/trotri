<!-- JavaScript -->
<?php echo $this->getHtml()->jsFile($this->static_url . '/plugins/bootstrap/' . $this->bootstrap_version . '/js/bootstrap.min.js'); ?>
<?php echo $this->getHtml()->jsFile($this->static_url . '/plugins/bootstrap-switch/bootstrap-switch.min.js'); ?>
<?php echo $this->getHtml()->jsFile($this->static_url . '/plugins/jquery-icheck/icheck.min.js'); ?>
<!-- /JavaScript -->

<!-- Trotri JS -->
<?php echo $this->getHtml()->jsFile($this->static_url . '/js/trotri-1.0.0.js?v=' . $this->version); ?>
<!-- Custom JS -->
<?php echo $this->getHtml()->jsFile($this->js_url . '/template.js?v=' . $this->version); ?>
