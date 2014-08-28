<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace system\services;

use libsrv\AbstractService;
use system\db\Options AS DbOptions;

/**
 * Options class file
 * 业务层：业务处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Options.php 1 2014-08-19 00:15:56Z Code Generator $
 * @package system.services
 * @since 1.0
 */
class Options extends AbstractService
{
	/**
	 * @var instance of system\db\Options
	 */
	protected $_dbOptions = null;

	/**
	 * 构造方法：初始化数据库操作类
	 */
	public function __construct()
	{
		parent::__construct();

		$this->_dbOptions = new DbOptions();
	}

	/**
	 * 获取所有的配置，以键值对方式返回
	 * @return array
	 */
	public function findPairs()
	{
		$rows = $this->_dbOptions->findPairs();
		return $rows;
	}

	/**
	 * 通过键名，编辑多条记录，如果键名不存在则新增记录
	 * @param integer $id
	 * @param array $params
	 * @return integer
	 */
	public function batchReplaceById($id, array $params = array())
	{
		return $this->batchReplace($params);
	}

	/**
	 * 通过键名，编辑多条记录，如果键名不存在则新增记录
	 * @param array $params
	 * @return integer
	 */
	public function batchReplace(array $params = array())
	{
		$formProcessor = $this->getFormProcessor();
		if (!$formProcessor->run($params)) {
			return false;
		}

		$attributes = $formProcessor->getValues();
		$rowCount = $this->getDb()->batchReplace($attributes);
		return $rowCount;
	}

	/**
	 * 通过键名，获取配置值
	 * @param string $optKey
	 * @return mixed
	 */
	public function getValueByKey($optKey)
	{
		$optValue = $this->_dbOptions->getValueByKey($optKey);
		return $optValue;
	}

	/**
	 * 获取“网站名称”
	 * @return string
	 */
	public function getSiteName()
	{
		$value = $this->getValueByKey('site_name');
		return $value ? $value : '';
	}

	/**
	 * 获取“网站URL”
	 * @return string
	 */
	public function getSiteUrl()
	{
		$value = $this->getValueByKey('site_url');
		return $value ? $value : '';
	}

	/**
	 * 获取“模板名称”
	 * @return string
	 */
	public function getTplDir()
	{
		$value = $this->getValueByKey('tpl_dir');
		return $value ? $value : '';
	}

	/**
	 * 获取“生成静态页面存放目录名称”
	 * @return string
	 */
	public function getHtmlDir()
	{
		$value = $this->getValueByKey('html_dir');
		return $value ? $value : '';
	}

	/**
	 * 获取“SEO Title”
	 * @return string
	 */
	public function getMetaTitle()
	{
		$value = $this->getValueByKey('meta_title');
		return $value ? $value : '';
	}

	/**
	 * 获取“SEO Keywords”
	 * @return string
	 */
	public function getMetaKeywords()
	{
		$value = $this->getValueByKey('meta_keywords');
		return $value ? $value : '';
	}

	/**
	 * 获取“SEO Description”
	 * @return string
	 */
	public function getMetaDescription()
	{
		$value = $this->getValueByKey('meta_description');
		return $value ? $value : '';
	}

	/**
	 * 获取“网站版权信息”
	 * @return string
	 */
	public function getPowerby()
	{
		$value = $this->getValueByKey('powerby');
		return $value ? $value : '';
	}

	/**
	 * 获取“网站第三方统计代码”
	 * @return string
	 */
	public function getStatCode()
	{
		$value = $this->getValueByKey('stat_code');
		return $value ? $value : '';
	}

	/**
	 * 获取“是否使用重写模式获取URLS”
	 * @return boolean
	 */
	public function isUrlRewrite()
	{
		$value = $this->getValueByKey('url_rewrite');
		return $value ? ($value === DataOptions::URL_REWRITE_Y ? true : false) : null;
	}

	/**
	 * 获取“是否关闭新用户注册”
	 * @return boolean
	 */
	public function isCloseRegister()
	{
		$value = $this->getValueByKey('close_register');
		return $value ? ($value === DataOptions::CLOSE_REGISTER_Y ? true : false) : null;
	}

	/**
	 * 获取“关闭注册原因”
	 * @return string
	 */
	public function getCloseRegisterReason()
	{
		$value = $this->getValueByKey('close_register_reason');
		return $value ? $value : '';
	}

	/**
	 * 获取“是否显示用户注册协议”
	 * @return boolean
	 */
	public function isShowRegisterServiceItem()
	{
		$value = $this->getValueByKey('show_register_service_item');
		return $value ? ($value === DataOptions::SHOW_REGISTER_SERVICE_ITEM_Y ? true : false) : null;
	}

	/**
	 * 获取“用户注册协议”
	 * @return string
	 */
	public function getRegisterServiceItem()
	{
		$value = $this->getValueByKey('register_service_item');
		return $value ? $value : '';
	}

	/**
	 * 获取“缩略图宽”
	 * @return integer
	 */
	public function getThumbWidth()
	{
		$value = $this->getValueByKey('thumb_width');
		return $value ? (int) $value : 0;
	}

	/**
	 * 获取“缩略图高”
	 * @return integer
	 */
	public function getThumbHeight()
	{
		$value = $this->getValueByKey('thumb_height');
		return $value ? (int) $value : 0;
	}

	/**
	 * 获取“水印类型”
	 * @return string
	 */
	public function getWaterMarkType()
	{
		$value = $this->getValueByKey('water_mark_type');
		return $value ? $value : '';
	}

	/**
	 * 获取“水印图片文件地址”
	 * @return string
	 */
	public function getWaterMarkImgdir()
	{
		$value = $this->getValueByKey('water_mark_imgdir');
		return $value ? $value : '';
	}

	/**
	 * 获取“水印文字信息”
	 * @return string
	 */
	public function getWaterMarkText()
	{
		$value = $this->getValueByKey('water_mark_text');
		return $value ? $value : '';
	}

	/**
	 * 获取“水印放置位置”
	 * @return integer
	 */
	public function getWaterMarkPosition()
	{
		$value = $this->getValueByKey('water_mark_position');
		return $value ? (int) $value : 0;
	}

	/**
	 * 获取“水印融合度”
	 * @return integer
	 */
	public function getWaterMarkPct()
	{
		$value = $this->getValueByKey('water_mark_pct');
		return $value ? (int) $value : 0;
	}

	/**
	 * 获取“SMTP服务器”
	 * @return string
	 */
	public function getSmtpHost()
	{
		$value = $this->getValueByKey('smtp_host');
		return $value ? $value : '';
	}

	/**
	 * 获取“SMTP服务器端口”
	 * @return integer
	 */
	public function getSmtpPort()
	{
		$value = $this->getValueByKey('smtp_port');
		return $value ? (int) $value : 0;
	}

	/**
	 * 获取“SMTP服务器的账号”
	 * @return string
	 */
	public function getSmtpUsername()
	{
		$value = $this->getValueByKey('smtp_username');
		return $value ? $value : '';
	}

	/**
	 * 获取“SMTP服务器的密码”
	 * @return string
	 */
	public function getSmtpPassword()
	{
		$value = $this->getValueByKey('smtp_password');
		return $value ? $value : '';
	}

	/**
	 * 获取“管理员邮箱”
	 * @return string
	 */
	public function getSmtpFrommail()
	{
		$value = $this->getValueByKey('smtp_frommail');
		return $value ? $value : '';
	}

	/**
	 * 获取“从$_GET或$_POST中获取当前页的键名”
	 * @return string
	 */
	public function getPageVar()
	{
		$value = $this->getValueByKey('page_var');
		return $value ? $value : '';
	}

	/**
	 * 获取“从$_GET或$_POST中获取每页展示的行数的键名”
	 * @return string
	 */
	public function getListRowsVar()
	{
		$value = $this->getValueByKey('list_rows_var');
		return $value ? $value : '';
	}

	/**
	 * 获取“每页展示的页码数”
	 * @return integer
	 */
	public function getListPages()
	{
		$value = $this->getValueByKey('list_pages');
		return $value ? (int) $value : 0;
	}

	/**
	 * 获取“每页展示的行数”
	 * @return integer
	 */
	public function getListRows()
	{
		$value = $this->getValueByKey('list_rows');
		return $value ? (int) $value : 0;
	}

	/**
	 * 获取“文档列表每页展示条数”
	 * @return integer
	 */
	public function getListRowsPosts()
	{
		$value = $this->getValueByKey('list_rows_posts');
		return $value ? (int) $value : 0;
	}

	/**
	 * 获取“用户列表每页展示条数”
	 * @return integer
	 */
	public function getListRowsUsers()
	{
		$value = $this->getValueByKey('list_rows_users');
		return $value ? (int) $value : 0;
	}

}
