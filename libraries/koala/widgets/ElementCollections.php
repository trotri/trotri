<?php
/**
 * Trotri Koala
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace koala\widgets;

use tfc\ap\ErrorException;
use tfc\ap\InvalidArgumentException;

/**
 * ElementCollections class file
 * 表单元素集合基类，寄存多个表单元素的配置
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ElementCollections.php 1 2013-05-18 14:58:59Z huan.song $
 * @package koala.widgets
 * @since 1.0
 */
class ElementCollections
{
	/**
	 * @var integer 表单元素配置类型：表格类型
	 */
	const TYPE_TABLE = 1;

	/**
	 * @var integer 表单元素配置类型：表单类型
	 */
	const TYPE_FORM = 2;

	/**
	 * @var integer 表单元素配置类型：查询表单类型
	 */
	const TYPE_SEARCH = 3;

	/**
	 * @var integer 表单元素配置类型：验证规则类型
	 */
	const TYPE_FILTER = 4;

	/**
	 * @var integer 表单元素配置类型：选项
	 */
	const TYPE_OPTIONS = 5;

	/**
	 * @var array 寄存所有的表单元素配置类型
	 */
	protected static $types = array(
		self::TYPE_TABLE,
		self::TYPE_FORM,
		self::TYPE_SEARCH,
		self::TYPE_FILTER,
		self::TYPE_OPTIONS
	);

	/**
	 * 获取表单元素配置，用于FormBuilder、TableBuilder或表单验证
	 * @param integer $type
	 * @param string $columnName
	 * @throws InvalidArgumentException 如果参数不是有效的表单元素配置类型，抛出异常
	 * @throws ErrorException 如果该表单元素名的getter方法不存在，抛出异常
	 */
	public function getElement($type, $columnName)
	{
		if (!in_array($type, self::$types)) {
			throw new InvalidArgumentException(sprintf(
				'ElementCollections Get Element Type "%d" invalid.', $type
			));
		}

		$method = 'get' . str_replace('_', '', $columnName);
		if (method_exists($this, $method)) {
            return $this->$method($type);
        }
        else {
            throw new ErrorException(sprintf(
                'Method "%s.%s" was not exists.', get_class($this), $method
            ));
        }
	}

	/**
	 * 获取Input表单元素分类标签，需要子类重写此方法
	 * @return array
	 */
	public function getViewTabs()
	{
	}
}
