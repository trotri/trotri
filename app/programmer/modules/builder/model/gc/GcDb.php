<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace modules\builder\model\gc;

use tfc\saf\Log;

/**
 * GcDb class file
 * 生成“数据库操作类”
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GcDb.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.model.gc
 * @since 1.0
 */
class GcDb extends AbstractGc
{
	const CLASS_COMMENT = '业务层：数据库操作类';

	/**
	 * (non-PHPdoc)
	 * @see modules\builder\model\gc.AbstractGc::_exec()
	 */
	protected function _exec()
	{
		Log::echoTrace('SRV Type "' . $this->schema->srvType . '" ...');

		if ($this->schema->srvType === 'dynamic') {
			$this->dynamic();
		}
	}

	/**
	 * 创建DynamicDB类
	 * @return void
	 */
	public function dynamic()
	{
		$fileManager = $this->fileManager;
		$schema = $this->schema;

		$filePath = $fileManager->db . DS . $schema->ucClsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);

		fwrite($stream, "namespace {$schema->srvName}\\db;\n\n");
		fwrite($stream, "use tdo\\DynamicDb;\n");
		fwrite($stream, "use {$schema->srvName}\\library\\Constant;\n\n");

		$fileManager->writeClassComment($stream, $schema->ucClsName, self::CLASS_COMMENT, "{$schema->srvName}.db");

		fwrite($stream, "class {$schema->ucClsName} extends DynamicDb\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * @var string 数据库配置名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tprotected \$_clusterName = Constant::DB_CLUSTER;\n");
		fwrite($stream, "}\n");

		fclose($stream);
	}
}
