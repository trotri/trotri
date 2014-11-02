<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace components\posts\helpers;

use libsrv\Service;

/**
 * Posts class file
 * 文档帮助类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Posts.php 1 2013-04-20 17:11:06Z huan.song $
 * @package components.posts.helpers
 * @since 1.0
 */
class Posts
{
	/**
	 * 查询多条头条
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public static function getHeads($limit = 0, $offset = 0)
	{
		$rows = self::getService()->getHeads($limit, $offset);
		return $rows;
	}

	/**
	 * 查询多条推荐
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public static function getRecommends($limit = 0, $offset = 0)
	{
		$rows = self::getService()->getRecommends($limit, $offset);
		return $rows;
	}

	/**
	 * 通过类别ID，查询多条记录
	 * @param integer $catId
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public static function getRowsByCatId($catId, $limit = 0, $offset = 0)
	{
		$rows = self::getService()->getRowsByCatId($catId, 'sort', $limit, $offset);
		return $rows;
	}

	/**
	 * 查询多条记录
	 * @param array $params
	 * @param string $order
	 * @param integer $limit
	 * @param integer $offset
	 * @return array
	 */
	public static function findRows(array $params = array(), $order = '', $limit = 0, $offset = 0)
	{
		$rows = self::getService()->findRows($params, $order, $limit, $offset);
		return $rows;
	}

	/**
	 * 通过主键，获取一篇文档
	 * @param integer $postId
	 * @return array
	 */
	public static function findByPk($postId)
	{
		$row = self::getService()->findByPk($postId);
		return $row;
	}

	/**
	 * 获取文档业务处理类
	 * @return posts\services\Posts
	 */
	public static function getService()
	{
		static $service = null;
		if ($service === null) {
			$service = Service::getInstance('Posts', 'posts');
		}

		return $service;
	}

}
