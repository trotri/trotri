<?php
/**
 * Trotri Base Classes
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace base;

use tfc\ap\ErrorException;

/**
 * EntityBuilder class file
 * 生成表的实体类
 * @author 宋欢 <trotri@yeah.net>
 * @version $Id: EntityBuilder.php 1 2013-05-18 14:58:59Z huan.song $
 * @package base
 * @since 1.0
 */
class EntityBuilder
{
    /**
     * @var instance of tfc\saf\DbProxy
     */
    protected $_dbProxy = null;

    /**
     * @var instance of base\DbMeta
     */
    protected $_dbMeta = null;

    /**
     * @var array instances of base\EntityBuilder
     */
    protected static $_instances = null;

    /**
     * 构造方法：初始化数据库操作类和MySQL表结构处理类
     * @param tfc\saf\DbProxy $dbProxy
     */
    protected function __construct(DbProxy $dbProxy)
    {
        $this->_dbProxy = $dbProxy;
        $this->_dbMeta = new DbMeta($this->getDbProxy());
    }

    /**
     * 单例模式：获取类的实例
     * @param tfc\saf\DbProxy $dbProxy
     * @return instance of base\EntityBuilder
     */
    public static function getInstance(DbProxy $dbProxy)
    {
        $clusterName = $dbProxy->getClusterName();
        if (!isset(self::$_instances[$clusterName])) {
            self::$_instances[$clusterName] = new self($dbProxy);
        }

        return self::$_instances[$clusterName];
    }

    /**
     * 获取实体类的反射对象
     * @param string $tableName
     * @return class reports
     */
    public function getRefClass($tableName)
    {
        require_once $this->getFile($tableName);
        return new \ReflectionClass('\\' . ucfirst(strtolower($tableName)));
    }

    /**
     * 获取实体类所在的文件名，如果文件不存在，会自动创建文件
     * @param string $tableName
     * @return string
     * @throws ErrorException 如果没有创建文件的权限，抛出异常
     */
    public function getFile($tableName)
    {
        $tableName = strtolower($tableName);
        $className = ucfirst($tableName);
        $path = $this->getDir() . DS . $className . '.php';
        if (is_file($path)) {
            return $path;
        }

        $tableSchema = $this->getDbMeta()->getTableSchema($tableName);

        if (!($stream = @fopen($path, 'w', false))) {
            throw new ErrorException(sprintf(
                'EntityBuilder file "%s" cannot be opened with mode "w"', $path
            ));
        }
        fwrite($stream, "<?php\n");
        fwrite($stream, "/**\n");
        fwrite($stream, " * {$className} class file\n");
        fwrite($stream, " * {$tableName} 表实体\n");
        fwrite($stream, " * @author auto create\n");
        fwrite($stream, " * @version \$Id: {$className}.php 1 " . date('Y-m-d H:i:s') . "Z auto create $\n");
        fwrite($stream, " * @package \n");
        fwrite($stream, " * @since 1.0\n");
        fwrite($stream, " */\n");

        fwrite($stream, "class {$className}\n");
        fwrite($stream, "{\n");
        fwrite($stream, "    /**\n");
        fwrite($stream, "     * @var string 表名\n");
        fwrite($stream, "     */\n");
        fwrite($stream, "    const TABLE_NAME = '" . $tableSchema->name . "';\n\n");

        fwrite($stream, "    /**\n");
        fwrite($stream, "     * @var string 自增字段名\n");
        fwrite($stream, "     */\n");
        fwrite($stream, "    const AUTO_INCREMENT = '" . $tableSchema->autoIncrement . "';\n\n");

        fwrite($stream, "    /**\n");
        fwrite($stream, "     * @var array|string 主键名\n");
        fwrite($stream, "     */\n");
        fwrite($stream, "    public static \$primaryKey = " . var_export($tableSchema->primaryKey, true) . ";\n\n");

        $comments = $this->getDbMeta()->getComments($tableName);
        foreach ($tableSchema->columnNames as $columnName) {
            $comment = isset($comments[$columnName]) ? $comments[$columnName] : '';
            $type = $tableSchema->columns[$columnName]->type;
            $defaultValue = isset($tableSchema->attributeDefaults[$columnName]) ? $tableSchema->attributeDefaults[$columnName] : '';
            if ($defaultValue !== '' && $type === 'string') {
                $defaultValue = '\'' . $defaultValue . '\'';
            }

            fwrite($stream, "    /**\n");
            fwrite($stream, "     * @var $type $comment\n");
            fwrite($stream, "     */\n");
            fwrite($stream, "    public \${$columnName}" . (($defaultValue !== '') ? " = $defaultValue" : "") . ";\n\n");
        }

        fwrite($stream, "}\n");
        return $path;
    }

    /**
     * 获取实体类所在的目录名，如果目录不存在，会自动创建目录
     * @return string
     * @throws ErrorException 如果创建目录失败，抛出异常
     */
    public function getDir()
    {
        $dir = DIR_DATA_RUNTIME_ENTITIES . DS . $this->getDbProxy()->getClusterName();
        $mode = 0664;
        if (!is_dir($dir)) {
            mkdir($dir, $mode, true);
        }

        if (!is_dir($dir)) {
            throw new ErrorException(sprintf(
                'EntityBuilder dir "%s" cannot be created with mode "%o" ', $dir, $mode
            ));
        }

        return $dir;
    }

    /**
     * 获取数据库操作类
     * @return tfc\saf\DbProxy
     */
    public function getDbProxy()
    {
        return $this->_dbProxy;
    }

    /**
     * 获取MySQL表结构处理类
     * @return base\DbMeta
     */
    public function getDbMeta()
    {
        return $this->_dbMeta;
    }
}
