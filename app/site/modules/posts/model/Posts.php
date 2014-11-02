<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\posts\model;

use libapp\BaseModel;
use tfc\saf\Cfg;
use libsrv\Service;
use libapp\PageHelper;
use system\services\Options;

/**
 * Posts class file
 * 文档管理
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Posts.php 1 2013-04-20 17:11:06Z huan.song $
 * @package modules.posts.model
 * @since 1.0
 */
class Posts extends BaseModel
{
	/**
	 * 通过类别ID，查询多条记录
	 * @param integer $catId
	 * @param integer $dt
	 * @param string $order
	 * @param integer $paged
	 * @return array
	 */
	public function findListByCatId($catId, $dt, $order = '', $paged = 0)
	{
		if (($catId = (int) $catId) <= 0) {
			return array();
		}

		$params = array('category_id' => $catId);
		if ((($dt = trim($dt)) !== '') && (($dt = strtotime($dt)) > 0)) {
			$params['dt_created_start'] = date('Y-m-01 00:00:00', $dt);
			$params['dt_created_end'] = date('Y-m-01 00:00:00', (strtotime($params['dt_created_start']) + MONTH_IN_SECONDS + WEEK_IN_SECONDS));
		}

		$data = $this->findLists($params, $order, $paged);
		if ($data && is_array($data)) {
			$data['attributes'] = array('catid' => $catId);
		}

		return $data;
	}

	/**
	 * 查询多条记录
	 * @param array $params
	 * @param string $order
	 * @param integer $paged
	 * @return array
	 */
	public function findLists(array $params = array(), $order = '', $paged = 0)
	{
		$paged = max((int) $paged, 1);
		$limit = $this->getListRows();
		$offset = PageHelper::getFirstRow($paged, $limit);

		$data = $this->getService()->findLists($params, $order, $limit, $offset);
		if ($data && is_array($data)) {
			$data['paged'] = $paged;
			$data['page_var'] = PageHelper::getPageVar();
		}

		return $data;
	}

	/**
	 * 获取分页参数：每页展示的行数
	 * @return integer
	 */
	public function getListRows()
	{
		$listRows = Options::getListRowsPosts();
		if ($listRows > 0) {
			return $listRows;
		}

		$listRows = (int) Cfg::getApp('list_rows', 'paginator');
		$listRows = max($listRows, 1);
		return $listRows;
	}

	/**
	 * 通过主键，查询一条记录
	 * @param integer $postId
	 * @return array
	 */
	public function findByPk($postId)
	{
		$row = $this->getService()->findByPk($postId);
		return $row;
	}

	/**
	 * 通过类别ID，查询上一条记录
	 * @param integer $catId
	 * @param integer $sort
	 * @return array
	 */
	public function findPrevByCatId($catId, $sort)
	{
		if (($catId = (int) $catId) <= 0) {
			return array();
		}

		if (($sort = (int) $sort) <= 0) {
			return array();
		}

		$params = array(
			'category_id' => $catId,
			'sort_end' => $sort,
		);

		$rows = $this->getService()->findRows($params, 'sort DESC', 1);
		if ($rows && is_array($rows) && isset($rows[0])) {
			return $rows[0];
		}

		return array();
	}

	/**
	 * 通过类别ID，查询下一条记录
	 * @param integer $catId
	 * @param integer $sort
	 * @return array
	 */
	public function findNextByCatId($catId, $sort)
	{
		if (($catId = (int) $catId) <= 0) {
			return array();
		}

		if (($sort = (int) $sort) <= 0) {
			return array();
		}

		$params = array(
			'category_id' => $catId,
			'sort_start' => $sort,
		);

		$rows = $this->getService()->findRows($params, 'sort', 1);
		if ($rows && is_array($rows) && isset($rows[0])) {
			return $rows[0];
		}

		return array();
	}

	/**
	 * 获取文档业务处理类
	 * @return posts\services\Posts
	 */
	public function getService()
	{
		static $service = null;
		if ($service === null) {
			$service = Service::getInstance('Posts', 'posts');
		}

		return $service;
	}
}
