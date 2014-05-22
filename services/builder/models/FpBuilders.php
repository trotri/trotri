<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace builder\models;

use libsrv\FormProcessor;
use libsrv\Clean;
use builder\library\Lang;

use tfc\validator\AlphaValidator;
use tfc\validator\AlphaNumValidator;
use tfc\validator\MinLengthValidator;
use tfc\validator\MaxLengthValidator;
use tfc\validator\MailValidator;
use tfc\validator\NotEmptyValidator;
use tfc\validator\InArrayValidator;

/**
 * FpBuilders class file
 * 业务层：表单数据处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: FpBuilders.php 1 2014-04-03 16:16:03Z Code Generator $
 * @package builder.models
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
			if (!$this->required($params,
				'builder_name', 'tbl_name', 'tbl_profile', 'tbl_engine', 'tbl_charset',
				'tbl_comment', 'app_name', 'mod_name', 'ctrl_name', 'cls_name', 'fk_column',
				'act_index_name', 'act_view_name', 'act_create_name', 'act_modify_name',
				'act_remove_name', 'index_row_btns', 'author_name', 'author_mail'
			)) {
				return false;
			}
		}

		$this->isValids($params,
			'builder_name', 'tbl_name', 'tbl_profile', 'tbl_engine', 'tbl_charset',
			'tbl_comment', 'app_name', 'mod_name', 'ctrl_name', 'cls_name', 'fk_column',
			'act_index_name', 'act_view_name', 'act_create_name', 'act_modify_name',
			'act_remove_name', 'index_row_btns', 'author_name', 'author_mail', 'srv_name', 'srv_type'
		);

		return !$this->hasError();
	}

	/**
	 * (non-PHPdoc)
	 * @see libsrv.FormProcessor::_cleanPreProcess()
	 */
	protected function _cleanPreProcess(array $params)
	{
		$rules = array(
			'builder_name' => 'trim',
			'tbl_name' => 'trim',
			'tbl_profile' => 'trim',
			'tbl_engine' => 'trim',
			'tbl_charset' => 'trim',
			'tbl_comment' => 'trim',
			'app_name' => 'trim',
			'mod_name' => 'trim',
			'ctrl_name' => 'trim',
			'cls_name' => 'trim',
			'fk_column' => 'trim',
			'act_index_name' => 'trim',
			'act_view_name' => 'trim',
			'act_create_name' => 'trim',
			'act_modify_name' => 'trim',
			'act_remove_name' => 'trim',
			'index_row_btns' => '\libsrv\Clean::trims',
			'author_name' => 'trim',
			'author_mail' => 'trim',
			'dt_created' => 'trim',
			'dt_modified' => 'trim',
		);

		$ret = $this->clean($rules, $params);
		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see libsrv.FormProcessor::_cleanPostProcess()
	 */
	protected function _cleanPostProcess()
	{
		$this->index_row_btns = Clean::join($this->index_row_btns);
	}

	/**
	 * 获取“生成代码名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getBuilderNameRule($value)
	{
		return array(
			'MinLength' => new MinLengthValidator($value, 6, Lang::_('MOD_FILTER_BUILDERS_BUILDER_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 50, Lang::_('MOD_FILTER_BUILDERS_BUILDER_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“表名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getTblNameRule($value)
	{
		return array(
			'AlphaNum' => new AlphaNumValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_TBL_NAME_ALPHANUM')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDERS_TBL_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 30, Lang::_('MOD_FILTER_BUILDERS_TBL_NAME_MAXLENGTH'))	
		);
	}

	/**
	 * 获取“是否生成扩展表”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getTblProfileRule($value)
	{
		$enum = DataBuilders::getTblProfileEnum();
		return array(
			'InArray' => new InArrayValidator($value, array_keys($enum), sprintf(Lang::_('MOD_FILTER_BUILDERS_TBL_PROFILE_INARRAY'), implode(', ', $enum)))
		);
	}

	/**
	 * 获取“表引擎”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getTblEngineRule($value)
	{
		$enum = DataBuilders::getTblEngineEnum();
		return array(
			'InArray' => new InArrayValidator($value, array_keys($enum), sprintf(Lang::_('MOD_FILTER_BUILDERS_TBL_ENGINE_INARRAY'), implode(', ', $enum)))
		);
	}

	/**
	 * 获取“表编码”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getTblCharsetRule($value)
	{
		$enum = DataBuilders::getTblCharsetEnum();
		return array(
			'InArray' => new InArrayValidator($value, array_keys($enum), sprintf(Lang::_('MOD_FILTER_BUILDERS_TBL_CHARSET_INARRAY'), implode(', ', $enum)))
		);
	}

	/**
	 * 获取“表描述”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getTblCommentRule($value)
	{
		return array(
			'NotEmpty' => new NotEmptyValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_TBL_COMMENT_NOTEMPTY')),
		);
	}

	/**
	 * 获取“应用名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getAppNameRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_APP_NAME_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDERS_APP_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 50, Lang::_('MOD_FILTER_BUILDERS_APP_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“模块名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getModNameRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_MOD_NAME_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDERS_MOD_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 50, Lang::_('MOD_FILTER_BUILDERS_MOD_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“控制器名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getCtrlNameRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_CTRL_NAME_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDERS_CTRL_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 12, Lang::_('MOD_FILTER_BUILDERS_CTRL_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“类名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getClsNameRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_CLS_NAME_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDERS_CLS_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 12, Lang::_('MOD_FILTER_BUILDERS_CLS_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“外联其他表的字段名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getFkColumnRule($value)
	{
		if ($value === '') {
			return array();
		}

		return array(
			'AlphaNum' => new AlphaNumValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_FK_COLUMN_ALPHANUM')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDERS_FK_COLUMN_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 50, Lang::_('MOD_FILTER_BUILDERS_FK_COLUMN_MAXLENGTH'))
		);
	}

	/**
	 * 获取“数据列表行动名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getActIndexNameRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_ACT_INDEX_NAME_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDERS_ACT_INDEX_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 12, Lang::_('MOD_FILTER_BUILDERS_ACT_INDEX_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“数据详情行动名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getActViewNameRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_ACT_VIEW_NAME_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDERS_ACT_VIEW_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 12, Lang::_('MOD_FILTER_BUILDERS_ACT_VIEW_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“新增数据行动名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getActCreateNameRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_ACT_CREATE_NAME_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDERS_ACT_CREATE_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 12, Lang::_('MOD_FILTER_BUILDERS_ACT_CREATE_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“编辑数据行动名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getActModifyNameRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_ACT_MODIFY_NAME_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDERS_ACT_MODIFY_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 12, Lang::_('MOD_FILTER_BUILDERS_ACT_MODIFY_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“删除数据行动名”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getActRemoveNameRule($value)
	{
		return array(
			'Alpha' => new AlphaValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_ACT_REMOVE_NAME_ALPHA')),
			'MinLength' => new MinLengthValidator($value, 2, Lang::_('MOD_FILTER_BUILDERS_ACT_REMOVE_NAME_MINLENGTH')),
			'MaxLength' => new MaxLengthValidator($value, 12, Lang::_('MOD_FILTER_BUILDERS_ACT_REMOVE_NAME_MAXLENGTH'))
		);
	}

	/**
	 * 获取“作者姓名，代码注释用”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getAuthorNameRule($value)
	{
		return array(
			'NotEmpty' => new NotEmptyValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_AUTHOR_NAME_NOTEMPTY')),
		);
	}

	/**
	 * 获取“作者邮箱”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getAuthorMailRule($value)
	{
		return array(
			'Mail' => new MailValidator($value, true, Lang::_('MOD_FILTER_BUILDERS_AUTHOR_MAIL_MAIL'))
		);
	}

	/**
	 * 获取“移至回收站”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getTrashRule($value)
	{
		$enum = DataBuilders::getTrashEnum();
		return array(
			'InArray' => new InArrayValidator($value, array_keys($enum), sprintf(Lang::_('MOD_FILTER_BUILDERS_TRASH_INARRAY'), implode(', ', $enum)))
		);
	}

	/**
	 * 获取“列表每行操作按钮”验证规则
	 * @param string $value
	 * @return array
	 */
	public function getIndexRowBtnsRule($value)
	{
		$enum = DataBuilders::getIndexRowBtnsEnum();
		return array(
			'InArray' => new InArrayValidator($value, array_keys($enum), sprintf(Lang::_('MOD_FILTER_BUILDERS_INDEX_ROW_BTNS_INARRAY'), implode(', ', $enum)))
		);
	}
}
