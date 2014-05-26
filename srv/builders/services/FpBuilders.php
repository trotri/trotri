<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace builders\services;

use libsrv\FormProcessor;
use tfc\validator;
use builders\library\Lang;

/**
 * FpBuilders class file
 * 业务层：表单数据处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FpBuilders.php 1 2014-05-26 19:25:19Z Code Generator $
 * @package builders.services
 * @since 1.0
 */
class FpBuilders extends FormProcessor
{
	/**
	 * (non-PHPdoc)
	 * @see libsrv.FormProcessor::_process()
	 */
	protected function _process(array $params = array())
	{
		if ($this->isInsert()) {
			if (!$this->required($params, 'builder_name', 'tbl_name', 'tbl_profile', 'tbl_engine', 'tbl_charset', 'tbl_comment', 'srv_type', 'srv_name', 'app_name', 'mod_name', 'cls_name', 'ctrl_name', 'fk_column', 'act_index_name', 'act_view_name', 'act_create_name', 'act_modify_name', 'act_remove_name', 'index_row_btns', 'description', 'author_name', 'author_mail', 'dt_created', 'dt_modified', 'trash')) {
				return false;
			}
		}

		$this->isValids($params, 'builder_name', 'tbl_name', 'tbl_profile', 'tbl_engine', 'tbl_charset', 'tbl_comment', 'srv_type', 'srv_name', 'app_name', 'mod_name', 'cls_name', 'ctrl_name', 'fk_column', 'act_index_name', 'act_view_name', 'act_create_name', 'act_modify_name', 'act_remove_name', 'index_row_btns', 'author_name', 'author_mail', 'trash');
		return !$this->hasError();
	}

	/**
	 * 获取“生成代码名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getBuilderNameRule($value)
	{
		return array(
			'MinLength' => new validator\MinLengthValidator($value, 6, Lang::_('SRV_FILTER_BUILDERS_BUILDER_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_BUILDERS_BUILDER_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“表名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getTblNameRule($value)
	{
		return array(
			'AlphaNum' => new validator\AlphaNumValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_TBL_NAME_ALPHANUM')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_TBL_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 30, Lang::_('SRV_FILTER_BUILDERS_TBL_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“是否生成扩展表”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getTblProfileRule($value)
	{
		$enum = DataBuilders::getTblProfileEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_BUILDERS_TBL_PROFILE_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“表引擎”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getTblEngineRule($value)
	{
		$enum = DataBuilders::getTblEngineEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_BUILDERS_TBL_ENGINE_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“表编码”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getTblCharsetRule($value)
	{
		$enum = DataBuilders::getTblCharsetEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_BUILDERS_TBL_CHARSET_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“表描述”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getTblCommentRule($value)
	{
		return array(
			'NotEmpty' => new validator\NotEmptyValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_TBL_COMMENT_NOTEMPTY')),
		);
	}

	/**
	 * 获取“代码类型”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getSrvTypeRule($value)
	{
		$enum = DataBuilders::getSrvTypeEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_BUILDERS_SRV_TYPE_INARRAY'), implode(', ', $enum))),
		);
	}

	/**
	 * 获取“业务名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getSrvNameRule($value)
	{
		return array(
			'Alpha' => new validator\AlphaValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_SRV_NAME_ALPHA')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_SRV_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_BUILDERS_SRV_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“应用名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getAppNameRule($value)
	{
		return array(
			'Alpha' => new validator\AlphaValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_APP_NAME_ALPHA')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_APP_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_BUILDERS_APP_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“模块名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getModNameRule($value)
	{
		return array(
			'Alpha' => new validator\AlphaValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_MOD_NAME_ALPHA')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_MOD_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_BUILDERS_MOD_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“类名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getClsNameRule($value)
	{
		return array(
			'Alpha' => new validator\AlphaValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_CLS_NAME_ALPHA')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_CLS_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 12, Lang::_('SRV_FILTER_BUILDERS_CLS_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“控制器名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getCtrlNameRule($value)
	{
		return array(
			'Alpha' => new validator\AlphaValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_CTRL_NAME_ALPHA')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_CTRL_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 12, Lang::_('SRV_FILTER_BUILDERS_CTRL_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“外联其他表的字段名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getFkColumnRule($value)
	{
		return array(
			'AlphaNum' => new validator\AlphaNumValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_FK_COLUMN_ALPHANUM')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_FK_COLUMN_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 50, Lang::_('SRV_FILTER_BUILDERS_FK_COLUMN_MAXLENGTH')),
		);
	}

	/**
	 * 获取“数据列表行动名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getActIndexNameRule($value)
	{
		return array(
			'Alpha' => new validator\AlphaValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_ACT_INDEX_NAME_ALPHA')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_ACT_INDEX_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 12, Lang::_('SRV_FILTER_BUILDERS_ACT_INDEX_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“数据详情行动名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getActViewNameRule($value)
	{
		return array(
			'Alpha' => new validator\AlphaValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_ACT_VIEW_NAME_ALPHA')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_ACT_VIEW_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 12, Lang::_('SRV_FILTER_BUILDERS_ACT_VIEW_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“新增数据行动名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getActCreateNameRule($value)
	{
		return array(
			'Alpha' => new validator\AlphaValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_ACT_CREATE_NAME_ALPHA')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_ACT_CREATE_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 12, Lang::_('SRV_FILTER_BUILDERS_ACT_CREATE_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“编辑数据行动名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getActModifyNameRule($value)
	{
		return array(
			'Alpha' => new validator\AlphaValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_ACT_MODIFY_NAME_ALPHA')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_ACT_MODIFY_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 12, Lang::_('SRV_FILTER_BUILDERS_ACT_MODIFY_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“删除数据行动名”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getActRemoveNameRule($value)
	{
		return array(
			'Alpha' => new validator\AlphaValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_ACT_REMOVE_NAME_ALPHA')),
			'MinLength' => new validator\MinLengthValidator($value, 2, Lang::_('SRV_FILTER_BUILDERS_ACT_REMOVE_NAME_MINLENGTH')),
			'MaxLength' => new validator\MaxLengthValidator($value, 12, Lang::_('SRV_FILTER_BUILDERS_ACT_REMOVE_NAME_MAXLENGTH')),
		);
	}

	/**
	 * 获取“数据列表每行操作Btn”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getIndexRowBtnsRule($value)
	{
		return array(
			'InArray' => new validator\InArrayValidator($value, array(), Lang::_('SRV_FILTER_BUILDERS_INDEX_ROW_BTNS_INARRAY')),
		);
	}

	/**
	 * 获取“作者姓名，代码注释用”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getAuthorNameRule($value)
	{
		return array(
			'NotEmpty' => new validator\NotEmptyValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_AUTHOR_NAME_NOTEMPTY')),
		);
	}

	/**
	 * 获取“作者邮箱，代码注释用”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getAuthorMailRule($value)
	{
		return array(
			'Mail' => new validator\MailValidator($value, true, Lang::_('SRV_FILTER_BUILDERS_AUTHOR_MAIL_MAIL')),
		);
	}

	/**
	 * 获取“移至回收站”验证规则
	 * @param mixed $value
	 * @return array
	 */
	public function getTrashRule($value)
	{
		$enum = DataBuilders::getTrashEnum();
		return array(
			'InArray' => new validator\InArrayValidator($value, array_keys($enum), sprintf(Lang::_('SRV_FILTER_BUILDERS_TRASH_INARRAY'), implode(', ', $enum))),
		);
	}

}
