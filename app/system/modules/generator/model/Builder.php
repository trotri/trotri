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

use library\ErrorNo;

use library\GeneratorFactory;

/**
 * Builder class file
 * 业务处理层类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Builder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package modules.generator.model
 * @since 1.0
 */
class Builder
{
	/**
	 * 生成代码
	 * @param integer $generatorId
	 * @return void
	 */
	public function create($generatorId)
	{
		$generators = $this->getGenerators($generatorId);
		$groups = $this->getGroups($generatorId);
		$fields = $this->getFields($generatorId);

		
	}

	/**
	 * 获取Fields
	 * @param integer $generatorId
	 * @return array
	 */
	public function getFields($generatorId)
	{
		$ret = GeneratorFactory::getModel('Fields')->findAllByAttributes(array('generator_id' => $generatorId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}
		$fields = $ret['data'];

		foreach ($fields as $key => $row) {
			$ret = GeneratorFactory::getModel('Validators')->findAllByAttributes(array('field_id' => $row['field_id']), 'sort');
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				$this->errExit(__LINE__, $ret['err_msg']);
			}
			$fields[$key]['validators'] = $ret['data'];

			$ret = GeneratorFactory::getModel('Types')->findByPk($row['type_id']);
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				$this->errExit(__LINE__, $ret['err_msg']);
			}
			$fields[$key]['types'] = $ret['data'];

			$ret = GeneratorFactory::getModel('Groups')->findByPk($row['group_id']);
			if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
				$this->errExit(__LINE__, $ret['err_msg']);
			}
			$fields[$key]['groups'] = $ret['data'];
		}

		return $fields;
	}

	/**
	 * 获取Groups
	 * @param integer $generatorId
	 * @return array
	 */
	public function getGroups($generatorId)
	{
		$ret = GeneratorFactory::getModel('Groups')->findAllByAttributes(array('generator_id' => 0), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}
		$default = $ret['data'];

		$ret = GeneratorFactory::getModel('Groups')->findAllByAttributes(array('generator_id' => $generatorId), 'sort');
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}
		$groups = $ret['data'];

		$ret = array_merge($default, $groups);
		return $ret;
	}

	/**
	 * 获取Generators
	 * @param integer $generatorId
	 * @return array
	 */
	public function getGenerators($generatorId)
	{
		$generatorId = (int) $generatorId;
		$ret = GeneratorFactory::getModel('Generators')->findByPk($generatorId);
		if ($ret['err_no'] !== ErrorNo::SUCCESS_NUM) {
			$this->errExit(__LINE__, $ret['err_msg']);
		}

		return $ret['data'];
	}

	/**
	 * 打印错误并退出
	 * @param string $errMsg
	 * @return void
	 */
	public function errExit($line, $errMsg)
	{
		echo '<font color="red">', $line, ' : ', $errMsg, '</font>';
		exit;
	}
}
