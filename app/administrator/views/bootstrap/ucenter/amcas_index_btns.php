<form class="form-inline">
  <button type="button" class="btn btn-primary" onclick="return Trotri.href('<?php echo $this->getUrlManager()->getUrl('create', '', ''); ?>');">
    <span class="glyphicon glyphicon-plus-sign"></span>
    <?php echo $this->CFG_SYSTEM_URLS_UCENTER_AMCAS_APPCREATE_LABEL; ?>
  </button>
<?php foreach ($this->app_amcas as $amcaId => $prompt) : ?>
<?php
$indexUrl = $this->getUrlManager()->getUrl('index', '', '', array('app_id' => $amcaId));
$createUrl = $this->getUrlManager()->getUrl('create', '', '', array('amca_pid' => $amcaId));
$modifyUrl = $this->getUrlManager()->getUrl('modify', '', '', array('id' => $amcaId));
$clsName = ($this->app_id == $amcaId) ? 'info' : 'default';
?>
  <a class="btn btn-<?php echo $clsName; ?>" href="<?php echo $indexUrl; ?>">
    <span 
    data-original-title="<?php echo $this->CFG_SYSTEM_URLS_UCENTER_AMCAS_MODCREATE_LABEL; ?>" 
    onclick="return Trotri.href('<?php echo $createUrl; ?>')" 
    class="glyphicon glyphicon-plus-sign" 
    data-toggle="tooltip" 
    data-placement="left"
    ></span>
    <span 
    data-original-title="<?php echo $this->CFG_SYSTEM_URLS_UCENTER_AMCAS_APPMODIFY_LABEL; ?>" 
    onclick="return Trotri.href('<?php echo $modifyUrl; ?>')" 
    class="glyphicon glyphicon-pencil" 
    data-toggle="tooltip" 
    data-placement="left"
    ></span>
    <?php echo $prompt; ?>
  </a>
<?php endforeach; ?>
</form>
