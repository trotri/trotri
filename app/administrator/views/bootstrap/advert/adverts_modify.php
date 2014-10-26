<?php
$this->widget('views\bootstrap\widgets\FormBuilder',
	array(
		'name' => 'modify',
		'action' => $this->getUrlManager()->getUrl($this->action, '', '', array('id' => $this->id)),
		'errors' => $this->errors,
		'values' => $this->data,
		'elements_object' => $this->elements,
		'elements' => array(
		),
		'columns' => array(
			'advert_name',
			'type_key',
			'description',
			'is_published',
			'dt_publish_up',
			'dt_publish_down',
			'sort',
			'show_type',
			'show_code',
			'title',
			'advert_url',
			'advert_src',
			'advert_src2',
			'attr_alt',
			'attr_width',
			'attr_height',
			'attr_fontsize',
			'attr_target',
			'dt_created',
			'_button_save_',
			'_button_saveclose_',
			'_button_savenew_',
			'_button_cancel_'
		)
	)
);
?>