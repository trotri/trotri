<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\generator\model;
use tfc\validator\Filter;

/**
 * Generators class file
 * 业务层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Generators.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Generators
{
	/**
	 * 新增一条记录
	 * @param array $params
	 * @return array
	 */
	public function create(array $params)
	{
		$rules = array (
			'generator_name' => array (
				'MinLength' => array (6, '生成代码名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array (12, '生成代码名长度%value%不能大于%option%个字符.')
			),
			'tbl_name' => array (
				'MinLength' => array (6, '表名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array (12, '表名长度%value%不能大于%option%个字符.')
			),
			'tbl_engine' => array (
				'InArray' => array (
					array ('MyISAM', 'InnoDB'), 
					'必须选择表引擎，值只能是MyISAM或InnoDB.'
				),
			),
			'tbl_charset' => array (
				'InArray' => array (
					array ('utf8', 'gbk', 'gb2312'),
					'必须选择表编码，值只能是utf8、gbk或gb2312.'
				),
			),
			'tbl_comment' => array (
				'NotEmpty' => array (true, '必须填写表描述.')
			),
			'app_name' => array (
				'MinLength' => array (6, '应用名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array (12, '应用名长度%value%不能大于%option%个字符.')
			),
			'mod_name' => array (
				'MinLength' => array (6, '模块名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array (12, '模块名长度%value%不能大于%option%个字符.')
			),
			'ctrl_name' => array (
				'MinLength' => array (6, '控制器名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array (12, '控制器名长度%value%不能大于%option%个字符.')
			),
			'act_index_name' => array (
				'MinLength' => array (6, '数据列表名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array (12, '数据列表名长度%value%不能大于%option%个字符.')
			),
			'act_view_name' => array (
				'MinLength' => array (6, '数据详情名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array (12, '数据详情名长度%value%不能大于%option%个字符.')
			),
			'act_create_name' => array (
				'MinLength' => array (6, '新增数据名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array (12, '新增数据名长度%value%不能大于%option%个字符.')
			),
			'act_modify_name' => array (
				'MinLength' => array (6, '编辑数据名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array (12, '编辑数据名长度%value%不能大于%option%个字符.')
			),
			'act_remove_name' => array (
				'MinLength' => array (6, '删除数据名长度%value%不能小于%option%个字符.'),
				'MaxLength' => array (12, '删除数据名长度%value%不能大于%option%个字符.')
			),
		);
		
		$filter = new Filter();
		
		echo '<pre>';
		var_dump($params);
		exit;
	}
}
