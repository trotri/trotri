<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace posts\services;

use libsrv\AbstractService;

/**
 * Posts class file
 * 业务层：业务处理类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Posts.php 1 2014-09-16 19:26:44Z Code Generator $
 * @package posts.services
 * @since 1.0
 */
class Posts extends AbstractService
{
	/**
	 * 通过多个字段名和值，查询多条记录，字段之间用简单的AND连接
	 * @param array $attributes
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findAllByAttributes(array $attributes = array(), $order = '', $limit = 0, $offset = 0)
	{
		$rows = $this->getDb()->findAll($attributes, $order, $limit, $offset);
		return $rows;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $postId
	 * @return array
	 */
	public function findByPk($postId)
	{
		$row = $this->getDb()->findByPk($postId);
		return $row;
	}

	/**
	 * 通过主键，获取某个列的值
	 * @param string $columnName
	 * @param integer $postId
	 * @return mixed
	 */
	public function getByPk($columnName, $postId)
	{
		$value = $this->getDb()->getByPk($columnName, $postId);
		return $value;
	}

	/**
	 * 通过“主键ID”，获取“文档标题”
	 * @param integer $postId
	 * @return string
	 */
	public function getTitleByPostId($postId)
	{
		$value = $this->getByPk('title', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“缩略图地址”
	 * @param integer $postId
	 * @return string
	 */
	public function getLittlePictureByPostId($postId)
	{
		$value = $this->getByPk('little_picture', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“所属类别”
	 * @param integer $postId
	 * @return integer
	 */
	public function getCategoryIdByPostId($postId)
	{
		$value = $this->getByPk('category_id', $postId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“类别名”
	 * @param integer $postId
	 * @return string
	 */
	public function getCategoryNameByPostId($postId)
	{
		$value = $this->getByPk('category_name', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“内容”
	 * @param integer $postId
	 * @return string
	 */
	public function getContentByPostId($postId)
	{
		$value = $this->getByPk('content', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“关键字”
	 * @param integer $postId
	 * @return string
	 */
	public function getKeywordsByPostId($postId)
	{
		$value = $this->getByPk('keywords', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“内容摘要”
	 * @param integer $postId
	 * @return string
	 */
	public function getDescriptionByPostId($postId)
	{
		$value = $this->getByPk('description', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“排序”
	 * @param integer $postId
	 * @return integer
	 */
	public function getSortByPostId($postId)
	{
		$value = $this->getByPk('sort', $postId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“是否发表”
	 * @param integer $postId
	 * @return string
	 */
	public function getIsPublicByPostId($postId)
	{
		$value = $this->getByPk('is_public', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“是否删除”
	 * @param integer $postId
	 * @return string
	 */
	public function getTrashByPostId($postId)
	{
		$value = $this->getByPk('trash', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“是否头条”
	 * @param integer $postId
	 * @return string
	 */
	public function getIsHeadByPostId($postId)
	{
		$value = $this->getByPk('is_head', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“是否推荐”
	 * @param integer $postId
	 * @return string
	 */
	public function getIsRecommendByPostId($postId)
	{
		$value = $this->getByPk('is_recommend', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“是否跳转”
	 * @param integer $postId
	 * @return string
	 */
	public function getIsJumpByPostId($postId)
	{
		$value = $this->getByPk('is_jump', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“跳转链接”
	 * @param integer $postId
	 * @return string
	 */
	public function getJumpUrlByPostId($postId)
	{
		$value = $this->getByPk('jump_url', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“生成静态页面”
	 * @param integer $postId
	 * @return string
	 */
	public function getIsHtmlByPostId($postId)
	{
		$value = $this->getByPk('is_html', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“生成静态页面链接”
	 * @param integer $postId
	 * @return string
	 */
	public function getHtmlUrlByPostId($postId)
	{
		$value = $this->getByPk('html_url', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“是否允许评论”
	 * @param integer $postId
	 * @return string
	 */
	public function getAllowCommentByPostId($postId)
	{
		$value = $this->getByPk('allow_comment', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“允许其他人编辑”
	 * @param integer $postId
	 * @return string
	 */
	public function getAllowOtherModifyByPostId($postId)
	{
		$value = $this->getByPk('allow_other_modify', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“访问次数”
	 * @param integer $postId
	 * @return integer
	 */
	public function getAccessCountByPostId($postId)
	{
		$value = $this->getByPk('access_count', $postId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“创建时间”
	 * @param integer $postId
	 * @return string
	 */
	public function getDtCreatedByPostId($postId)
	{
		$value = $this->getByPk('dt_created', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“发布时间”
	 * @param integer $postId
	 * @return string
	 */
	public function getDtPublicByPostId($postId)
	{
		$value = $this->getByPk('dt_public', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“上次编辑时间”
	 * @param integer $postId
	 * @return string
	 */
	public function getDtLastModifiedByPostId($postId)
	{
		$value = $this->getByPk('dt_last_modified', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“创建人”
	 * @param integer $postId
	 * @return integer
	 */
	public function getCreatorIdByPostId($postId)
	{
		$value = $this->getByPk('creator_id', $postId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“创建人”
	 * @param integer $postId
	 * @return string
	 */
	public function getCreatorNameByPostId($postId)
	{
		$value = $this->getByPk('creator_name', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“上次编辑人”
	 * @param integer $postId
	 * @return integer
	 */
	public function getLastModifierIdByPostId($postId)
	{
		$value = $this->getByPk('last_modifier_id', $postId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“上次编辑人”
	 * @param integer $postId
	 * @return string
	 */
	public function getLastModifierNameByPostId($postId)
	{
		$value = $this->getByPk('last_modifier_name', $postId);
		return $value ? $value : '';
	}

	/**
	 * 通过“主键ID”，获取“创建IP”
	 * @param integer $postId
	 * @return integer
	 */
	public function getIpCreatedByPostId($postId)
	{
		$value = $this->getByPk('ip_created', $postId);
		return $value ? (int) $value : 0;
	}

	/**
	 * 通过“主键ID”，获取“上次编辑IP”
	 * @param integer $postId
	 * @return integer
	 */
	public function getIpLastModifiedByPostId($postId)
	{
		$value = $this->getByPk('ip_last_modified', $postId);
		return $value ? (int) $value : 0;
	}

}
