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
 * GcService class file
 * 生成“业务层业务处理类”
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: GcService.php 1 2014-01-18 14:19:29Z huan.song $
 * @package modules.builder.model.gc
 * @since 1.0
 */
class GcService extends AbstractGc
{
	const CLASS_COMMENT = '业务层：业务处理类';

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
	 * 创建DynamicService类
	 * @return void
	 */
	public function dynamic()
	{
		$fileManager = $this->fileManager;
		$schema = $this->schema;

		$filePath = $fileManager->services . DS . $schema->ucClsName . '.php';
		$stream = $fileManager->fopen($filePath);
		$fileManager->writeCopyrightComment($stream);

		fwrite($stream, "namespace {$schema->srvName}\\services;\n\n");
		fwrite($stream, "use libsrv\\DynamicService;\n\n");

		$fileManager->writeClassComment($stream, $schema->ucClsName, self::CLASS_COMMENT, "{$schema->srvName}.services");

		fwrite($stream, "class {$schema->ucClsName} extends DynamicService\n");
		fwrite($stream, "{\n");
		fwrite($stream, "\t/**\n");
		fwrite($stream, "\t * @var string 表名\n");
		fwrite($stream, "\t */\n");
		fwrite($stream, "\tprotected \$_tableName = '{$schema->tblName}';\n");
		fwrite($stream, "}\n");

		fclose($stream);
	}
}
