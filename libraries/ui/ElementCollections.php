<?php
/**
 * Trotri Ui
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace ui;

use tfc\ap\ErrorException;
use tfc\ap\InvalidArgumentException;
use tfc\ap\Singleton;
use tfc\mvc\Mvc;

/**
 * ElementCollections class file
 * 字段信息寄存基类，包括表格、表单、验证规则、选项
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ElementCollections.php 1 2013-05-18 14:58:59Z huan.song $
 * @package ui
 * @since 1.0
 */
class ElementCollections
{
	/**
	 * @var integer 字段信息类型：表格信息
	 */
	const TYPE_TABLE = 1;

	/**
	 * @var integer 字段信息类型：表单信息
	 */
	const TYPE_FORM = 2;

	/**
	 * @var integer 字段信息类型：查询表单信息
	 */
	const TYPE_SEARCH = 3;

	/**
	 * @var integer 字段信息类型：验证规则信息
	 */
	const TYPE_FILTER = 4;

	/**
	 * @var integer 字段信息类型：选项信息
	 */
	const TYPE_OPTIONS = 5;

	/**
	 * @var array 寄存所有的字段信息类型
	 */
	protected static $types = array(
		self::TYPE_TABLE,
		self::TYPE_FORM,
		self::TYPE_SEARCH,
		self::TYPE_FILTER,
		self::TYPE_OPTIONS
	);

	/**
	 * @var instance 寄存当前的页面小组件类
	 */
	protected $_uiComponents = null;

	/**
	 * 获取字段信息，用于FormBuilder、TableBuilder、SearchBuilder或FormValidator等
	 * @param integer $type
	 * @param string $columnName
	 * @throws InvalidArgumentException 如果字段信息类型无效，抛出异常
	 * @throws ErrorException 如果该字段名的getter方法不存在，抛出异常
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
	public function getViewTabsRender()
	{
	}
}
