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

use libapp\BaseModel;
use tfc\saf\Cfg;
use libsrv\Service;
use libapp\PageHelper;

/**
 * Comments class file
 * 文档评论
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Comments.php 1 2014-10-31 11:14:54Z Code Generator $
 * @package modules.posts.model
 * @since 1.0
 */
class Comments extends BaseModel
{
	/**
	 * 通过文档ID，查询多条记录
	 * @param integer $catId
	 * @param string $order
	 * @param integer $paged
	 * @return array
	 */
	public function findListByPostId($postId, $order = '', $paged = 0)
	{
		if (($postId = (int) $postId) <= 0) {
			return array();
		}

		$service = $this->getService();

		$ret = $this->findAll(array('post_id' => $postId, 'comment_pid' => 0), $order, $paged);
		if ($ret && is_array($ret)) {
			$ret['attributes'] = array('postid' => $postId);
			if (isset($ret['rows']) && is_array($ret['rows'])) {
				foreach ($ret['rows'] as $key => $row) {
					$data = $service->findRows(array('comment_pid' => $row['comment_id']), $order);
					if ($data && is_array($data)) {
						foreach ($data as $_k => $_r) {
							$data[$_k]['data'] = $service->findRows(array('comment_pid' => $_r['comment_id']), $order);
						}

						$ret['rows'][$key]['data'] = $data;
					}
				}
			}
		}

		return $ret;
	}

	/**
	 * 查询多条记录
	 * @param array $params
	 * @param string $order
	 * @param integer $paged
	 * @return array
	 */
	public function findAll(array $params = array(), $order = '', $paged = 0)
	{
		$paged = max((int) $paged, 1);
		$limit = $this->getListRows();
		$offset = PageHelper::getFirstRow($paged, $limit);

		$params['is_published'] = 'y';
		$ret = $this->getService()->findAll($params, $order, $limit, $offset);
		if ($ret && is_array($ret) && isset($ret['rows']) && is_array($ret['rows'])) {
			$ret['paged'] = $paged;
			$ret['page_var'] = PageHelper::getPageVar();
		}

		return $ret;
	}

	/**
	 * 获取分页参数：每页展示的行数
	 * @return integer
	 */
	public function getListRows()
	{
		$listRows = 3;
		if ($listRows > 0) {
			return $listRows;
		}

		$listRows = (int) Cfg::getApp('list_rows', 'paginator');
		$listRows = max($listRows, 1);
		return $listRows;
	}

	/**
	 * 新增一条记录
	 * @param array $params
	 * @param boolean $ignore
	 * @return array
	 */
	public function create(array $params = array(), $ignore = false)
	{
		$ret = $this->callCreateMethod($this->getService(), 'create', $params, $ignore);
		return $ret;
	}

	/**
	 * 获取文档评论业务处理类
	 * @return posts\services\Comments
	 */
	public function getService()
	{
		static $service = null;
		if ($service === null) {
			$service = Service::getInstance('Comments', 'posts');
		}

		return $service;
	}
}
