<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace posts\db;

use tdo\AbstractDb;
use posts\library\Constant;
use posts\library\TableNames;

/**
 * Posts class file
 * 业务层：数据库操作类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Posts.php 1 2014-09-16 19:05:47Z Code Generator $
 * @package posts.db
 * @since 1.0
 */
class Posts extends AbstractDb
{
	/**
	 * @var string 数据库配置名
	 */
	protected $_clusterName = Constant::DB_CLUSTER;

	/**
	 * 查询多条记录
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public function findAll(array $params = array(), $order = '', $limit = 0, $offset = 0)
	{
		$attributes = $params;

		if (isset($attributes['dt_created_start'])) {
			$dtCreatedStart = trim($attributes['dt_created_start']);
			if ($dtCreatedStart !== '') {
				$attributes['dt_created >= '] = $dtCreatedStart;
			}

			unset($attributes['dt_created_start']);
		}

		if (isset($attributes['dt_created_end'])) {
			$dtCreatedEnd = trim($attributes['dt_created_end']);
			if ($dtCreatedEnd !== '') {
				$attributes['dt_created <= '] = $dtCreatedEnd;
			}

			unset($attributes['dt_created_end']);
		}

		if (isset($attributes['dt_public_start'])) {
			$dtPublicStart = trim($attributes['dt_public_start']);
			if ($dtPublicStart !== '') {
				$attributes['dt_public >= '] = $dtPublicStart;
			}

			unset($attributes['dt_public_start']);
		}

		if (isset($attributes['dt_public_end'])) {
			$dtPublicEnd = trim($attributes['dt_public_end']);
			if ($dtPublicEnd !== '') {
				$attributes['dt_public <= '] = $dtPublicEnd;
			}

			unset($attributes['dt_public_end']);
		}

		if (isset($attributes['dt_last_modified_start'])) {
			$dtLastModifiedStart = trim($attributes['dt_last_modified_start']);
			if ($dtLastModifiedStart !== '') {
				$attributes['dt_last_modified >= '] = $dtLastModifiedStart;
			}

			unset($attributes['dt_last_modified_start']);
		}

		if (isset($attributes['dt_last_modified_end'])) {
			$dtLastModifiedEnd = trim($attributes['dt_last_modified_end']);
			if ($dtLastModifiedEnd !== '') {
				$attributes['dt_last_modified <= '] = $dtLastModifiedEnd;
			}

			unset($attributes['dt_last_modified_end']);
		}

		if (isset($attributes['access_count_start'])) {
			$accessCountStart = trim($attributes['access_count_start']);
			if ($accessCountStart !== '') {
				$attributes['access_count >= '] = $accessCountStart;
			}

			unset($attributes['access_count_start']);
		}

		if (isset($attributes['access_count_end'])) {
			$accessCountEnd = trim($attributes['access_count_end']);
			if ($accessCountEnd !== '') {
				$attributes['access_count <= '] = $accessCountEnd;
			}

			unset($attributes['access_count_end']);
		}

		$commandBuilder = $this->getCommandBuilder();
		$tableName = $this->getTblprefix() . TableNames::getPosts();
		$condition = $commandBuilder->createAndCondition(array_keys($attributes));

		$sql = 'SELECT SQL_CALC_FOUND_ROWS `post_id`, `title`, `little_picture`, `category_id`, `category_name`, `keywords`, `description`, `sort`, `is_public`, `trash`, `is_head`, `is_recommend`, `is_jump`, `jump_url`, `is_html`, `html_url`, `allow_comment`, `allow_other_modify`, `access_count`, `dt_created`, `dt_public`, `dt_last_modified`, `creator_id`, `creator_name`, `last_modifier_id`, `last_modifier_name`, `ip_created`, `ip_last_modified` FROM `' . $tableName . '`';
		$sql = $commandBuilder->applyCondition($sql, $condition);
		$sql = $commandBuilder->applyOrder($sql, $order);
		$sql = $commandBuilder->applyLimit($sql, $limit, $offset);
		$ret = $this->fetchAllNoCache($sql, $attributes);
		if (is_array($ret)) {
			$ret['attributes'] = $params;
			$ret['order']      = $order;
			$ret['limit']      = $limit;
			$ret['offset']     = $offset;
		}

		return $ret;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $postId
	 * @return array
	 */
	public function findByPk($postId)
	{
		if (($postId = (int) $postId) <= 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getPosts();
		$sql = 'SELECT `post_id`, `title`, `little_picture`, `category_id`, `category_name`, `content`, `keywords`, `description`, `sort`, `is_public`, `trash`, `is_head`, `is_recommend`, `is_jump`, `jump_url`, `is_html`, `html_url`, `allow_comment`, `allow_other_modify`, `access_count`, `dt_created`, `dt_public`, `dt_last_modified`, `creator_id`, `creator_name`, `last_modifier_id`, `last_modifier_name`, `ip_created`, `ip_last_modified` FROM `' . $tableName . '` WHERE `post_id` = ?';
		return $this->fetchAssoc($sql, $postId);
	}

	/**
	 * 通过主键，获取某个列的值
	 * @param string $columnName
	 * @param integer $postId
	 * @return mixed
	 */
	public function getByPk($columnName, $postId)
	{
		$row = $this->findByPk($postId);
		if ($row && is_array($row) && isset($row[$columnName])) {
			return $row[$columnName];
		}

		return false;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return integer
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$title = isset($params['title']) ? trim($params['title']) : '';
		$littlePicture = isset($params['little_picture']) ? trim($params['little_picture']) : '';
		$categoryId = isset($params['category_id']) ? (int) $params['category_id'] : 0;
		$categoryName = isset($params['category_name']) ? trim($params['category_name']) : '';
		$content = isset($params['content']) ? $params['content'] : '';
		$keywords = isset($params['keywords']) ? trim($params['keywords']) : '';
		$description = isset($params['description']) ? $params['description'] : '';
		$sort = isset($params['sort']) ? (int) $params['sort'] : 0;
		$isPublic = isset($params['is_public']) ? trim($params['is_public']) : '';
		$isHead = isset($params['is_head']) ? trim($params['is_head']) : '';
		$isRecommend = isset($params['is_recommend']) ? trim($params['is_recommend']) : '';
		$isJump = isset($params['is_jump']) ? trim($params['is_jump']) : '';
		$jumpUrl = isset($params['jump_url']) ? trim($params['jump_url']) : '';
		$isHtml = isset($params['is_html']) ? trim($params['is_html']) : '';
		$htmlUrl = isset($params['html_url']) ? trim($params['html_url']) : '';
		$allowComment = isset($params['allow_comment']) ? trim($params['allow_comment']) : '';
		$allowOtherModify = isset($params['allow_other_modify']) ? trim($params['allow_other_modify']) : '';
		$accessCount = isset($params['access_count']) ? (int) $params['access_count'] : 0;
		$dtCreated = isset($params['dt_created']) ? trim($params['dt_created']) : '';
		$dtPublic = isset($params['dt_public']) ? trim($params['dt_public']) : '';
		$dtLastModified = isset($params['dt_last_modified']) ? trim($params['dt_last_modified']) : '';
		$creatorId = isset($params['creator_id']) ? (int) $params['creator_id'] : 0;
		$creatorName = isset($params['creator_name']) ? trim($params['creator_name']) : '';
		$lastModifierId = isset($params['last_modifier_id']) ? (int) $params['last_modifier_id'] : 0;
		$lastModifierName = isset($params['last_modifier_name']) ? trim($params['last_modifier_name']) : '';
		$ipCreated = isset($params['ip_created']) ? (int) $params['ip_created'] : 0;
		$ipLastModified = isset($params['ip_last_modified']) ? (int) $params['ip_last_modified'] : 0;
		$trash = 'n';

		if ($title === '' || $categoryId <= 0 || $categoryName === '' || $keywords === '' || $sort <= 0
			|| $isPublic === '' || $isHead === '' || $isRecommend === '' || $isJump === '' || $isHtml === '' || $allowComment === ''
			|| $accessCount < 0 || $dtCreated === '' || $dtPublic === '' || $dtLastModified === ''
			|| $creatorId <= 0 || $creatorName === '' || $lastModifierId <= 0 || $lastModifierName === '') {
			return false;
		}

		if ($isJump === 'y' && $jumpUrl === '') {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getPosts();
		$attributes = array(
			'title' => $title,
			'little_picture' => $littlePicture,
			'category_id' => $categoryId,
			'category_name' => $categoryName,
			'content' => $content,
			'keywords' => $keywords,
			'description' => $description,
			'sort' => $sort,
			'is_public' => $isPublic,
			'is_head' => $isHead,
			'is_recommend' => $isRecommend,
			'is_jump' => $isJump,
			'jump_url' => $jumpUrl,
			'is_html' => $isHtml,
			'html_url' => $htmlUrl,
			'allow_comment' => $allowComment,
			'allow_other_modify' => $allowOtherModify,
			'access_count' => $accessCount,
			'dt_created' => $dtCreated,
			'dt_public' => $dtPublic,
			'dt_last_modified' => $dtLastModified,
			'creator_id' => $creatorId,
			'creator_name' => $creatorName,
			'last_modifier_id' => $lastModifierId,
			'last_modifier_name' => $lastModifierName,
			'ip_created' => $ipCreated,
			'ip_last_modified' => $ipLastModified,
			'trash' => $trash,
		);

		$sql = $this->getCommandBuilder()->createInsert($tableName, array_keys($attributes), $ignore);
		return $this->insert($sql, $attributes);
	}

	/**
	 * 通过主键，编辑一条记录
	 * @param integer $postId
	 * @param array $params
	 * @return integer
	 */
	public function modifyByPk($postId, array $params = array())
	{
		if (($postId = (int) $postId) <= 0) {
			return false;
		}

		$attributes = array();

		if (isset($params['title'])) {
			$title = trim($params['title']);
			if ($title !== '') {
				$attributes['title'] = $title;
			}
			else {
				return false;
			}
		}

		if (isset($params['little_picture'])) {
			$littlePicture = trim($params['little_picture']);
			if ($littlePicture !== '') {
				$attributes['little_picture'] = $littlePicture;
			}
		}

		if (isset($params['category_id'])) {
			$categoryId = (int) $params['category_id'];
			if ($categoryId > 0) {
				$attributes['category_id'] = $categoryId;
			}
		}

		if (isset($params['category_name'])) {
			$categoryName = trim($params['category_name']);
			if ($categoryName !== '') {
				$attributes['category_name'] = $categoryName;
			}
		}

		if ((isset($attributes['category_id']) && !isset($attributes['category_name']))
			|| (isset($attributes['category_name']) && !isset($attributes['category_id']))) {
			return false;
		}

		if (isset($params['content'])) {
			$attributes['content'] = $params['content'];
		}

		if (isset($params['keywords'])) {
			$keywords = trim($params['keywords']);
			if ($keywords !== '') {
				$attributes['keywords'] = $keywords;
			}
		}

		if (isset($params['description'])) {
			$attributes['description'] = $params['description'];
		}

		if (isset($params['sort'])) {
			$sort = (int) $params['sort'];
			if ($sort > 0) {
				$attributes['sort'] = $sort;
			}
		}

		if (isset($params['is_public'])) {
			$isPublic = trim($params['is_public']);
			if ($isPublic !== '') {
				$attributes['is_public'] = $isPublic;
			}
		}

		if (isset($params['trash'])) {
			$trash = trim($params['trash']);
			if ($trash !== '') {
				$attributes['trash'] = $trash;
			}
		}

		if (isset($params['is_head'])) {
			$isHead = trim($params['is_head']);
			if ($isHead !== '') {
				$attributes['is_head'] = $isHead;
			}
		}

		if (isset($params['is_recommend'])) {
			$isRecommend = trim($params['is_recommend']);
			if ($isRecommend !== '') {
				$attributes['is_recommend'] = $isRecommend;
			}
		}

		if (isset($params['is_jump'])) {
			$isJump = trim($params['is_jump']);
			if ($isJump !== '') {
				$attributes['is_jump'] = $isJump;
			}
		}

		if (isset($params['jump_url'])) {
			$jumpUrl = trim($params['jump_url']);
			if ($jumpUrl !== '') {
				$attributes['jump_url'] = $jumpUrl;
			}
		}

		if (isset($params['is_html'])) {
			$isHtml = trim($params['is_html']);
			if ($isHtml !== '') {
				$attributes['is_html'] = $isHtml;
			}
		}

		if (isset($params['html_url'])) {
			$htmlUrl = trim($params['html_url']);
			if ($htmlUrl !== '') {
				$attributes['html_url'] = $htmlUrl;
			}
		}

		if (isset($params['allow_comment'])) {
			$allowComment = trim($params['allow_comment']);
			if ($allowComment !== '') {
				$attributes['allow_comment'] = $allowComment;
			}
		}

		if (isset($params['allow_other_modify'])) {
			$allowOtherModify = trim($params['allow_other_modify']);
			if ($allowOtherModify !== '') {
				$attributes['allow_other_modify'] = $allowOtherModify;
			}
		}

		if (isset($params['access_count'])) {
			$accessCount = (int) $params['access_count'];
			if ($accessCount >= 0) {
				$attributes['access_count'] = $accessCount;
			}
		}

		if (isset($params['dt_created'])) {
			$dtCreated = trim($params['dt_created']);
			if ($dtCreated !== '') {
				$attributes['dt_created'] = $dtCreated;
			}
		}

		if (isset($params['dt_public'])) {
			$dtPublic = trim($params['dt_public']);
			if ($dtPublic !== '') {
				$attributes['dt_public'] = $dtPublic;
			}
		}

		if (isset($params['dt_last_modified'])) {
			$dtLastModified = trim($params['dt_last_modified']);
			if ($dtLastModified !== '') {
				$attributes['dt_last_modified'] = $dtLastModified;
			}
		}

		if (isset($params['creator_id'])) {
			$creatorId = (int) $params['creator_id'];
			if ($creatorId > 0) {
				$attributes['creator_id'] = $creatorId;
			}
		}

		if (isset($params['creator_name'])) {
			$creatorName = trim($params['creator_name']);
			if ($creatorName !== '') {
				$attributes['creator_name'] = $creatorName;
			}
		}

		if ((isset($attributes['creator_id']) && !isset($attributes['creator_name']))
			|| (isset($attributes['creator_name']) && !isset($attributes['creator_id']))) {
			return false;
		}

		if (isset($params['last_modifier_id'])) {
			$lastModifierId = (int) $params['last_modifier_id'];
			if ($lastModifierId > 0) {
				$attributes['last_modifier_id'] = $lastModifierId;
			}
		}

		if (isset($params['last_modifier_name'])) {
			$lastModifierName = trim($params['last_modifier_name']);
			if ($lastModifierName !== '') {
				$attributes['last_modifier_name'] = $lastModifierName;
			}
		}

		if ((isset($attributes['last_modifier_id']) && !isset($attributes['last_modifier_name']))
			|| (isset($attributes['last_modifier_name']) && !isset($attributes['last_modifier_id']))) {
			return false;
		}

		if (isset($params['ip_created'])) {
			$attributes['ip_created'] = (int) $params['ip_created'];
		}

		if (isset($params['ip_last_modified'])) {
			$attributes['ip_last_modified'] = (int) $params['ip_last_modified'];
		}

		if ($attributes === array()) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getPosts();
		$sql = $this->getCommandBuilder()->createUpdate($tableName, array_keys($attributes), '`post_id` = ?');
		$attributes['post_id'] = $postId;
		return $this->update($sql, $attributes);
	}

	/**
	 * 通过主键，删除一条记录
	 * @param integer $postId
	 * @return integer
	 */
	public function removeByPk($postId)
	{
		if (($postId = (int) $postId) <= 0) {
			return false;
		}

		$tableName = $this->getTblprefix() . TableNames::getPosts();
		$sql = $this->getCommandBuilder()->createDelete($tableName, '`post_id` = ?');
		return $this->delete($sql, $postId);
	}
}
