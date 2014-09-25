<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\posts\model;

use library\BaseModel;
use tfc\mvc\Mvc;
use tfc\saf\Text;
use libapp\Model;
use posts\services\DataPosts;
use users\library\Identity;

/**
 * Posts class file
 * 文档管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Posts.php 1 2014-09-16 19:32:26Z Code Generator $
 * @package modules.posts.model
 * @since 1.0
 */
class Posts extends BaseModel
{
	/**
	 * (non-PHPdoc)
	 * @see \libapp\Elements::getViewTabsRender()
	 */
	public function getViewTabsRender()
	{
		$output = array(
			'advanced' => array(
				'tid' => 'advanced',
				'prompt' => Text::_('MOD_POSTS_POSTS_VIEWTAB_ADVANCED_PROMPT')
			),
			'system' => array(
				'tid' => 'system',
				'prompt' => Text::_('MOD_POSTS_POSTS_VIEWTAB_SYSTEM_PROMPT')
			),
		);

		return $output;
	}

	/**
	 * (non-PHPdoc)
	 * @see \libapp\Elements::getElementsRender()
	 */
	public function getElementsRender()
	{
		$urlManager = Mvc::getView()->getUrlManager();
		$nowTime = date('Y-m-d H:i:s');
		$output = array(
			'post_id' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
				'label' => Text::_('MOD_POSTS_POSTS_POST_ID_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_POST_ID_HINT'),
			),
			'title' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POSTS_TITLE_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_TITLE_HINT'),
				'required' => true,
			),
			'category_id' => array(
				'__tid__' => 'main',
				'type' => 'select',
				'label' => Text::_('MOD_POSTS_POSTS_CATEGORY_ID_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_CATEGORY_ID_HINT'),
			),
			'category_name' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POSTS_CATEGORY_NAME_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_CATEGORY_NAME_HINT'),
			),
			'little_picture' => array(
				'__tid__' => 'main',
				'type' => 'hidden',
			),
			'little_picture_file' => array(
				'__tid__' => 'main',
				'type' => 'string',
				'label' => Text::_('MOD_POSTS_POSTS_LITTLE_PICTURE_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_LITTLE_PICTURE_HINT'),
				'value' => '<div id="little_picture_file" url="' . $urlManager->getUrl('upload', '', '', array('from' => 'little_picture')) . '" name="upload">Upload</div>',
			),
			'content' => array(
				'__tid__' => 'main',
				'type' => 'ckeditor',
				'id' => 'content',
				'height' => '960px',
				'toolbar' => 'post',
				'url' => $urlManager->getUrl('upload', '', '', array('from' => 'ckeditor'))
			),
			'keywords' => array(
				'__tid__' => 'main',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POSTS_KEYWORDS_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_KEYWORDS_HINT'),
				'required' => true,
			),
			'description' => array(
				'__tid__' => 'main',
				'type' => 'textarea',
				'label' => Text::_('MOD_POSTS_POSTS_DESCRIPTION_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_DESCRIPTION_HINT'),
				'rows' => 10
			),
			'is_public' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POSTS_IS_PUBLIC_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_IS_PUBLIC_HINT'),
				'options' => DataPosts::getIsPublicEnum(),
				'value' => DataPosts::IS_PUBLIC_Y,
			),
			'trash' => array(
				'__tid__' => 'main',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POSTS_TRASH_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_TRASH_HINT'),
				'options' => DataPosts::getTrashEnum(),
				'value' => DataPosts::TRASH_Y,
			),
			'sort' => array(
				'__tid__' => 'advanced',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POSTS_SORT_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_SORT_HINT'),
				'required' => true,
				'value' => 10000
			),
			'is_head' => array(
				'__tid__' => 'advanced',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POSTS_IS_HEAD_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_IS_HEAD_HINT'),
				'options' => DataPosts::getIsHeadEnum(),
				'value' => DataPosts::IS_HEAD_N,
			),
			'is_recommend' => array(
				'__tid__' => 'advanced',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POSTS_IS_RECOMMEND_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_IS_RECOMMEND_HINT'),
				'options' => DataPosts::getIsRecommendEnum(),
				'value' => DataPosts::IS_RECOMMEND_N,
			),
			'is_jump' => array(
				'__tid__' => 'advanced',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POSTS_IS_JUMP_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_IS_JUMP_HINT'),
				'options' => DataPosts::getIsJumpEnum(),
				'value' => DataPosts::IS_JUMP_N,
			),
			'jump_url' => array(
				'__tid__' => 'advanced',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POSTS_JUMP_URL_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_JUMP_URL_HINT'),
				'required' => true,
			),
			'is_html' => array(
				'__tid__' => 'advanced',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POSTS_IS_HTML_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_IS_HTML_HINT'),
				'options' => DataPosts::getIsHtmlEnum(),
				'value' => DataPosts::IS_HTML_Y,
			),
			'html_url' => array(
				'__tid__' => 'advanced',
				'type' => 'hidden',
				'label' => Text::_('MOD_POSTS_POSTS_HTML_URL_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_HTML_URL_HINT'),
			),
			'allow_comment' => array(
				'__tid__' => 'advanced',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POSTS_ALLOW_COMMENT_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_ALLOW_COMMENT_HINT'),
				'options' => DataPosts::getAllowCommentEnum(),
				'value' => DataPosts::ALLOW_COMMENT_Y,
			),
			'allow_other_modify' => array(
				'__tid__' => 'advanced',
				'type' => 'switch',
				'label' => Text::_('MOD_POSTS_POSTS_ALLOW_OTHER_MODIFY_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_ALLOW_OTHER_MODIFY_HINT'),
				'options' => DataPosts::getAllowOtherModifyEnum(),
				'value' => DataPosts::ALLOW_OTHER_MODIFY_Y,
			),
			'access_count' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POSTS_ACCESS_COUNT_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_ACCESS_COUNT_HINT'),
				'required' => true,
				'value' => mt_rand(100, 999)
			),
			'dt_created' => array(
				'__tid__' => 'system',
				'type' => 'datetimepicker',
				'label' => Text::_('MOD_POSTS_POSTS_DT_CREATED_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_DT_CREATED_HINT'),
				'required' => true,
				'value' => $nowTime
			),
			'dt_public' => array(
				'__tid__' => 'system',
				'type' => 'datetimepicker',
				'label' => Text::_('MOD_POSTS_POSTS_DT_PUBLIC_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_DT_PUBLIC_HINT'),
				'required' => true,
				'value' => $nowTime
			),
			'dt_last_modified' => array(
				'__tid__' => 'system',
				'type' => 'datetimepicker',
				'label' => Text::_('MOD_POSTS_POSTS_DT_LAST_MODIFIED_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_DT_LAST_MODIFIED_HINT'),
				'required' => true,
				'value' => $nowTime
			),
			'creator_id' => array(
				'__tid__' => 'system',
				'type' => 'hidden',
				'label' => Text::_('MOD_POSTS_POSTS_CREATOR_ID_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_CREATOR_ID_HINT'),
				'value' => Identity::getUserId()
			),
			'creator_name' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POSTS_CREATOR_NAME_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_CREATOR_NAME_HINT'),
				'disabled' => true,
				'value' => Identity::getLoginName()
			),
			'last_modifier_id' => array(
				'__tid__' => 'system',
				'type' => 'hidden',
				'label' => Text::_('MOD_POSTS_POSTS_LAST_MODIFIER_ID_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_LAST_MODIFIER_ID_HINT'),
				'value' => Identity::getUserId()
			),
			'last_modifier_name' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POSTS_LAST_MODIFIER_NAME_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_LAST_MODIFIER_NAME_HINT'),
				'disabled' => true,
				'value' => Identity::getLoginName()
			),
			'ip_created' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POSTS_IP_CREATED_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_IP_CREATED_HINT'),
				'disabled' => true,
			),
			'ip_last_modified' => array(
				'__tid__' => 'system',
				'type' => 'text',
				'label' => Text::_('MOD_POSTS_POSTS_IP_LAST_MODIFIED_LABEL'),
				'hint' => Text::_('MOD_POSTS_POSTS_IP_LAST_MODIFIED_HINT'),
				'disabled' => true,
			),
		);

		return $output;
	}

	/**
	 * 获取列表页“文档标题”的A标签
	 * @param array $data
	 * @return string
	 */
	public function getTitleLink($data)
	{
		$params = array(
			'id' => $data['post_id'],
		);

		$url = $this->urlManager->getUrl($this->actNameView, $this->controller, $this->module, $params);
		$output = $this->html->a($data['title'], $url);
		return $output;
	}

	/**
	 * 获取“是否头条”
	 * @param string $isHead
	 * @return string
	 */
	public function getIsHeadLangByIsHead($isHead)
	{
		$ret = $this->getService()->getIsHeadLangByIsHead($isHead);
		return $ret;
	}

	/**
	 * 获取“是否推荐”
	 * @param string $isRecommend
	 * @return string
	 */
	public function getIsRecommendLangByIsRecommend($isRecommend)
	{
		$ret = $this->getService()->getIsRecommendLangByIsRecommend($isRecommend);
		return $ret;
	}

	/**
	 * 获取“是否发表”
	 * @param string $isPublic
	 * @return string
	 */
	public function getIsPublicLangByIsPublic($isPublic)
	{
		$ret = $this->getService()->getIsPublicLangByIsPublic($isPublic);
		return $ret;
	}

	/**
	 * 查询数据列表
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function search(array $params = array(), $order = '', $limit = null, $offset = null)
	{
		$rules = array(
			'title' => 'trim',
			'post_id' => 'intval',
			'category_id' => 'intval',
			'is_head' => 'trim',
			'is_recommend' => 'trim',
			'is_jump' => 'trim',
			'is_html' => 'trim',
			'allow_comment' => 'trim',
			'is_public' => 'trim',
			'access_count' => 'trim',
			'creator_id' => 'trim',
			'dt_created' => 'trim',
			'dt_public' => 'trim',
			'dt_last_modified' => 'trim',
			'trash' => 'trim',
		);

		$this->filterCleanEmpty($params, $rules);
		$ret = parent::search($this->getService(), $params, $order, $limit, $offset);
		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see \library\BaseModel::findByPk()
	 */
	public function findByPk($value)
	{
		$ret = parent::findByPk($value);
		if (isset($ret['data']) && is_array($ret['data'])) {
			if (isset($ret['data']['ip_created'])) {
				$ret['data']['ip_created'] = long2ip($ret['data']['ip_created']);
			}

			if (isset($ret['data']['ip_last_modified'])) {
				$ret['data']['ip_last_modified'] = long2ip($ret['data']['ip_last_modified']);
			}
		}

		return $ret;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return array
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$params['creator_id'] = $params['last_modifier_id'] = Identity::getUserId();
		return parent::create($params, $ignore);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $id
	 * @param array $params
	 * @return array
	 */
	public function modifyByPk($id, array $params = array())
	{
		if (isset($params['last_modifier_id'])) {
			$params['last_modifier_id'] = Identity::getUserId();
		}

		return parent::modifyByPk($id, $params);
	}

	/**
	 * 递归方式获取所有的类别名，默认用空格填充子类别左边用于和父类别错位
	 * （只返回ID和类别名的键值对）（可用于Select表单的Option选项）
	 * @param integer $categoryPid
	 * @param string $padStr
	 * @param string $leftPad
	 * @param string $rightPad
	 * @return array
	 */
	public function getCategoryNames($categoryPid = 0, $padStr = '&nbsp;&nbsp;&nbsp;&nbsp;', $leftPad = '', $rightPad = null)
	{
		return Model::getInstance('Categories')->getOptions($categoryPid, $padStr, $leftPad, $rightPad);
	}
}
