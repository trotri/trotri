<!-- Footer -->
<hr>

<?php $this->display('dialogs/trash_remove'); ?>
<?php $this->display('dialogs/alert'); ?>

<footer>
<!-- p>&copy; Company 2013</p -->
</footer>

<?php if ($this->warning_backtrace) : ?>
<div class="alert alert-danger"><?php echo $this->warning_backtrace; ?></div>
<?php endif; ?>

<!-- /Footer -->
