<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\action\schema;

use library\actions;
use tfc\ap\Ap;
use libapp\Service;

/**
 * Gb class file
 * 通过表Metadata生成Builders数据
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: Gb.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.action.schema
 * @since 1.0
 */
class Gb extends actions\Remove
{
	/**
	 * (non-PHPdoc)
	 * @see tfc\mvc\interfaces.Action::run()
	 */
	public function run()
	{
		$tblName = Ap::getRequest()->getTrim('tbl_name');
		if ($tblName === '') {
			$this->err404();
		}

		$srv = Service::getInstance('Schema');
		$srv->gb($tblName);
	}
}
