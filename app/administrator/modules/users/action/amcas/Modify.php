<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2014 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\users\action\amcas;

use library\actions;
use libapp\Model;

/**
 * Modify class file
 * 编辑数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Modify.php 1 2014-05-29 14:36:52Z Code Generator $
 * @package modules.users.action.amcas
 * @since 1.0
 */
class Modify extends actions\Modify
{
	/**
	 * (non-PHPdoc)
	 * @see \tfc\mvc\interfaces\Action::run()
	 */
	public function run()
	{
		$mod = Model::getInstance('Amcas');
		$amcaPid = $mod->getAmcaPid();
		if ($amcaPid <= 0) {
			$this->err404();
		}

		$this->assign('amca_pid', $amcaPid);
		$this->execute('Amcas');
	}
}
