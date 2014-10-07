<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

return array(
	'system' => array(
		'directory' => 'imgs', // 上传目录名，在根目录：DIR_DATA_UPLOAD下
		'name_pre' => '',
		'name_rule' => 0, // 保存文件时的命名规则，0：原文件名、1：随机整数格式、2：随机字符串格式、3：日期和时间格式、4：日期和时间+随机整数格式、5：日期和时间+随机字符串格式、6：时间戳格式、7：时间戳+随机整数格式、8：时间戳+随机字符串格式
		'max_size' => 2097152, // 允许上传的文件大小最大值，单位：字节
		'allow_types' => array(
			'image/pjpeg',
			'image/jpeg',
			'image/gif',
			'image/png',
			'image/xpng',
			'image/wbmp',
			'image/bmp',
			'image/x-png'
		),
		'allow_exts' => 'jpg|gif|png|bmp|zip|rar',
		'allow_replace_exists' => false, // 如果保存文件的地址已经存在其他文件，是否允许替换
		'dt_format' => 'YmdHis',
		'join_str' => '_',
		'rand_min' => 10000,
		'rand_max' => 99999,
		'rand_strlen' => 16
	),
);
