<?php
$this->widget('views\bootstrap\widgets\ViewBuilder',
	array(
		'name' => 'view',
		'values' => $this->data,
		'elements_object' => $this->elements,
		'elements' => array(
			'category_id' => array(
				'options' => $this->elements->getCategoryNames()
			),
		),
		'columns' => array(
			'post_id',
			'title',
			'category_id',
			'little_picture_img',
			'little_picture_file',
			'little_picture',
			'content',
			'keywords',
			'description',
			'is_public',
			'sort',
			'is_head',
			'is_recommend',
			'is_jump',
			'jump_url',
			'is_html',
			'allow_comment',
			'access_count',
			'dt_created',
			'dt_public',
			'dt_last_modified',
			'creator_id',
			'creator_name',
			'last_modifier_id',
			'last_modifier_name',
			'ip_created',
			'ip_last_modified',
			'_button_history_back_'
		)
	)
);
?>