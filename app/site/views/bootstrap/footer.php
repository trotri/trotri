<div class="blog-footer">
  <p><?php echo $this->system_powerby ; ?>.</p>
  <p>
    <a href="#">Back to top</a>
  </p>
</div>
<!-- /Footer -->

<?php if ($this->warning_backtrace) : ?>
<div class="alert alert-danger"><?php echo $this->warning_backtrace; ?></div>
<?php endif; ?>
