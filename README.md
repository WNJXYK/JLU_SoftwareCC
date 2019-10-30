# JLU_SoftwareCC
A Project for JLU Software Comprehensive Course

## Group Member

* WNJXYK 周植
* HGZDG 朱任翔
* u049 胡子木
* HKFDBG 王登泰
* lwger 李舞桂

## How to install Canvas

1. 将 ./Web 文件夹中内容负责到服务器中，并进入服务器对应目录
2. 将 ./SQL/*.sql 导入数据库，根据实际情况选择（推荐 Canvas.sql）
3. 根据实际情况修改 ./Web/libs/config.php
```php
<?php
    if (!defined("MYSQL_HOST")) define("MYSQL_HOST", "localhost"); // 数据库连接地址
    if (!defined("MYSQL_DATABASE")) define("MYSQL_DATABASE", "canvas"); // 数据库名
    if (!defined("MYSQL_USERNAME")) define("MYSQL_USERNAME", "Canvas"); // 数据库用户名
    if (!defined("MYSQL_PASSWORD")) define("MYSQL_PASSWORD", "Canvas"); // 数据库密码
    if (!defined("MYSQL_PREFIX")) define("MYSQL_PREFIX", ""); // 数据库表前缀
    define("Folder_PATH", "/Group2"); // 如果你的程序不在网站根目录下执行，那么请在这里填写程序相对网址根目录位置
    define("WWW_PATH", $_SERVER['DOCUMENT_ROOT'] . Folder_PATH); // 无需修改
    define("URL_PATH", "http://canvas.keji.moe" . Folder_PATH); // 请在这里填写网站的域名
?>
```

管理员账户为 `19260817`，密码为 `admin`，Have fun.
