<?php
/**
 * Trotri
 *
 * @author    Huan Song <trotri@yeah.net>
 * @link      http://github.com/trotri/trotri for the canonical source repository
 * @copyright Copyright &copy; 2011-2013 http://www.trotri.com/ All rights reserved.
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */
?>
<?php
define('REQUIRED_PHP_VERSION', '5.3.0');
define('DS',               DIRECTORY_SEPARATOR);
define('DIR_ROOT',         substr(dirname(__FILE__), 0, -8));
define('DIR_CFG_DB',       DIR_ROOT . DS . 'cfg' . DS . 'db');
define('DIR_DATA_INSTALL', DIR_ROOT . DS . 'data' . DS . 'install');

$baseUrl = getBaseUrl();
$do = isset($_GET['do']) ? trim($_GET['do']) : '';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Trotri</title>
<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/static/plugins/bootstrap/3.0.3/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $baseUrl; ?>/static/plugins/bootstrap/3.0.3/css/bootstrap-theme.min.css" />
<style type="text/css">.container { width: 1170px; }</style>
</head>

<body>
<div class="container">
  <div class="jumbotron"><h1>欢迎使用Trotri!</h1></div>

<?php if ($do === '') : ?>
  <?php $hasError = false; ?>
  <div class="jumbotron">
  <p>
    PHP版本&nbsp;
    <?php if (version_compare(REQUIRED_PHP_VERSION, phpversion(), '<=')) : ?>
    <span class="glyphicon glyphicon-ok"></span>
    <?php else : ?>
    <?php $hasError = true; ?>
    <span class="glyphicon glyphicon-remove"></span>&nbsp;<small>必须是5.3或5.3以上版本！</small>
    <?php endif; ?>
  </p>
  <p>
    PDO支持&nbsp;
    <?php if (class_exists('PDO')) : ?>
    <span class="glyphicon glyphicon-ok"></span>
    <?php else : ?>
    <?php $hasError = true; ?>
    <span class="glyphicon glyphicon-remove"></span>&nbsp;<small>无法操作MySQL数据库！</small>
    <?php endif; ?>
  </p>
  <p>
    /cfg/db目录可写权限&nbsp;
    <?php if (is_writeable(DIR_CFG_DB)) : ?>
    <span class="glyphicon glyphicon-ok"></span>
    <?php else : ?>
    <?php $hasError = true; ?>
    <span class="glyphicon glyphicon-remove"></span>&nbsp;<small>无法写入DB配置文件！</small>
    <?php endif; ?>
  </p>
  <p>
    /data/install目录可读权限&nbsp;
    <?php if (is_readable(DIR_DATA_INSTALL)) : ?>
    <span class="glyphicon glyphicon-ok"></span>
    <?php else : ?>
    <?php $hasError = true; ?>
    <span class="glyphicon glyphicon-remove"></span>&nbsp;<small>无法读取SQL安装文件！</small>
    <?php endif; ?>
  </p>
  <p>安装需要一些数据库信息，用来导入SQL安装文件。</p>
  <p>1. 数据库名</p>
  <p>2. 数据库用户名</p>
  <p>3. 数据库密码</p>
  <p>4. 数据库主机</p>
  <p>5. 数据表前缀</p>
  <p>这些数据库信息将被写入/cfg/db/cluster.php配置文件。</p>
  <p>如果自动创建/cfg/db/cluster.php配置文件失败，请手动将这些数据库信息写入/cfg/db/cluster-sample.php文件，并将cluster-sample.php文件重命名为cluster.php。</p>
  <p></p>
  <?php if (!$hasError) : ?>
  <p><a class="btn btn-primary btn-lg" href="install.php?do=dbform">继续 &gt;&gt;</a></p>
  <?php endif; ?>
  </div>
<?php endif; ?>

<?php if ($do === 'dbform') : ?>
  <div class="row"><form class="form-horizontal" name="dbform" action="install.php?do=dbsubmit" method="post">
    <div class="form-group">
      <label class="col-lg-2 control-label">数据库名</label>
      <div class="col-lg-4">
        <input class="form-control input-sm" type="text" name="dbname" value="test">
      </div>
      <span class="control-label"></span>
    </div>

    <div class="form-group">
      <label class="col-lg-2 control-label">数据库用户名</label>
      <div class="col-lg-4">
        <input class="form-control input-sm" type="text" name="username" value="root">
      </div>
      <span class="control-label">MySQL用户名</span>
    </div>

    <div class="form-group">
      <label class="col-lg-2 control-label">数据库密码</label>
      <div class="col-lg-4">
        <input class="form-control input-sm" type="text" name="password" value="123456">
      </div>
      <span class="control-label">MySQL密码</span>
    </div>

    <div class="form-group">
      <label class="col-lg-2 control-label">数据库主机</label>
      <div class="col-lg-4">
        <input class="form-control input-sm" type="text" name="dbhost" value="localhost">
      </div>
      <span class="control-label">通常都是localhost</span>
    </div>

    <div class="form-group">
      <label class="col-lg-2 control-label">数据表前缀</label>
      <div class="col-lg-4">
        <input class="form-control input-sm" type="text" name="tblprefix" value="tr_">
      </div>
      <span class="control-label"></span>
    </div>

    <div class="form-group">
      <div class="col-lg-1"></div>
      <div class="col-lg-11">
        <button class="btn btn-primary btn-lg" type="submit" name="_button_save_">继续 &gt;&gt;</button>
      </div>
    </div>
  </form></div>
<?php endif; ?>

<?php if ($do === 'dbsubmit') : ?>
  <?php
  $dbname    = isset($_POST['dbname'])    ? trim($_POST['dbname'])    : '';
  $username  = isset($_POST['username'])  ? trim($_POST['username'])  : '';
  $password  = isset($_POST['password'])  ? trim($_POST['password'])  : '';
  $dbhost    = isset($_POST['dbhost'])    ? trim($_POST['dbhost'])    : '';
  $tblprefix = isset($_POST['tblprefix']) ? strtolower(trim($_POST['tblprefix'])) : '';
  substr($tblprefix, -1) === '_' || $tblprefix .= '_';
  ?>

  <?php if (!preg_match('/^[a-z]+\w+$/i', $tblprefix)) : ?>
  <div class="jumbotron">
    <h2>数据表前缀错误&nbsp;<span class="glyphicon glyphicon-remove"></span></h2>
    <p>1. 数据表前缀不能为空</p>
    <p>2. 数据表前缀只能由英文字母开头</p>
    <p>3. 数据表前缀只能由英文字母、数字或下划线组成</p>
    <p><a class="btn btn-primary btn-lg" href="javascript: history.back();">&lt;&lt; 返回上一步</a></p>
  </div>
  <?php exit; endif; ?>

  <?php $db = mysql_connect($dbhost, $username, $password); ?>
  <?php if (!$db) : ?>
  <div class="jumbotron">
    <h2>数据库连接错误&nbsp;<span class="glyphicon glyphicon-remove"></span></h2>
    <p>1. 请确认用户名和密码是否正确？</p>
    <p>2. 请确认主机名是否正确？</p>
    <p>3. 请确认数据库服务器是否正常运行？</p>
    <p><a class="btn btn-primary btn-lg" href="javascript: history.back();">&lt;&lt; 返回上一步</a></p>
  </div>
  <?php exit; endif; ?>

  <?php
  $version = mysql_get_server_info($db);
  if ($version > '4.1') {
    $command = 'SET character_set_connection=UTF8, character_set_results=UTF8, character_set_client=binary';
    if ($version > '5.0.1') {
      $command .= ", sql_mode=''";
    }

    mysql_query($command, $db);
  }
  ?>

  <?php if (!mysql_select_db($dbname, $db)) : ?>
  <?php mysql_close($db); ?>
  <div class="jumbotron">
    <h2>无法选择数据库&nbsp;<span class="glyphicon glyphicon-remove"></span></h2>
    <p>1. 请确认数据库是否存在？</p>
    <p>2. 请确认用户<?php echo $username; ?>是否拥有使用<?php echo $dbname; ?>数据库的权限？</p>
    <p><a class="btn btn-primary btn-lg" href="javascript: history.back();">&lt;&lt; 返回上一步</a></p>
  </div>
  <?php exit; endif; ?>

  <?php if ($db) { mysql_close($db); } ?>
  <?php endif; ?>

</div>
</body>

<?php
/**
 * 获取当前应用的路径
 * @return string
 */
function getBaseUrl()
{
	$scriptName = isset($_SERVER['SCRIPT_FILENAME']) ? basename($_SERVER['SCRIPT_FILENAME']) : '';
	if (isset($_SERVER['SCRIPT_NAME']) && (basename($_SERVER['SCRIPT_NAME']) === $scriptName)) {
		$scriptUrl = $_SERVER['SCRIPT_NAME'];
	}
	elseif (isset($_SERVER['PHP_SELF']) && (basename($_SERVER['PHP_SELF']) === $scriptName)) {
		$scriptUrl = $_SERVER['PHP_SELF'];
	}
	elseif (isset($_SERVER['ORIG_SCRIPT_NAME']) && (basename($_SERVER['ORIG_SCRIPT_NAME']) === $scriptName)) {
		$scriptUrl = $_SERVER['ORIG_SCRIPT_NAME'];
	}
	elseif (($pos = strpos($_SERVER['PHP_SELF'], '/' . $scriptName)) !== false) {
		$scriptUrl = substr($_SERVER['SCRIPT_NAME'], 0, $pos) . '/' . $scriptName;
	}
	elseif (isset($_SERVER['DOCUMENT_ROOT']) && (strpos($_SERVER['SCRIPT_FILENAME'], $_SERVER['DOCUMENT_ROOT']) === 0)) {
		$scriptUrl = str_replace('\\', '/', str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']));
	}
	else {
		$scriptUrl = '';
	}

	$baseUrl = rtrim(dirname($scriptUrl), '\\/');
	return $baseUrl;
}
?>