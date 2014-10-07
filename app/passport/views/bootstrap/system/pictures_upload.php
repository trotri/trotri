<?php
$html = $this->getHtml();
$urlManager = $this->getUrlManager();

echo $html->openTag('div', array('class' => 'col-lg-4'));
echo $html->tag('div', array('id' => 'batch_upload_picture_file', 'url' => $urlManager->getUrl('ajaxupload', '', ''), 'name' => 'upload'), 'Upload');
echo $html->closeTag('/div');
?>

<input type="hidden" name="little_picture" value="">