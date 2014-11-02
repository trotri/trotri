<!-- DtArchives -->
<div class="sidebar-module">
  <h4><?php echo $this->title; ?></h4>
  <ol class="list-unstyled">
    <?php foreach ($this->archives as $dtYm) : ?>
    <li><a href="index.php?com=list"><?php echo $dtYm; ?></a></li>
    <?php endforeach; ?>
  </ol>
</div>
<!-- /DtArchives -->
