<!-- Friendlinks -->
<?php if ($this->is_show) : ?>
<div class="sidebar-module">
  <h4><?php echo $this->type_name; ?></h4>
  <ol class="list-unstyled">
    <?php foreach ($this->adverts as $i => $rows) : ?>
    <li><?php echo isset($rows['show_code']) ? $rows['show_code'] : ''; ?></li>
    <?php endforeach; ?>
  </ol>
</div>
<?php endif; ?>
<!-- /Friendlinks -->