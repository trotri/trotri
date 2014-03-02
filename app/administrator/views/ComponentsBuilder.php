<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace views;

/**
 * ComponentsBuilder interface file
 * 创建页面小组件接口
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: ComponentsBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package views
 * @since 1.0
 */
interface ComponentsBuilder
{
	/**
	 * 获取表单的“保存”按钮信息
	 * @param array $params
	 * @return array
	 */
	public function getButtonSave(array $params = array());

	/**
	 * 获取表单的“保存并关闭”按钮信息
	 * @param array $params
	 * @return array
	 */
	public function getButtonSaveClose(array $params = array());

	/**
	 * 获取表单的“保存并新建”按钮信息
	 * @param array $params
	 * @return array
	 */
	public function getButtonSaveNew(array $params = array());

	/**
	 * 获取表单的“取消”按钮信息
	 * @param array $params
	 * @return array
	 */
	public function getButtonCancel(array $params = array());

	/**
	 * 获取美化版“是|否”选择项表单元素
	 * @param array $params
	 * @return string
	 */
	public function getSwitch(array $params = array());

	/**
	 * 获取Glyphicons图标按钮和工具提示
	 * @param array $params
	 * @return string
	 */
	public function getGlyphicon(array $params = array());
}
