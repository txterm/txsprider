# txsprider

txsprider 蜘蛛程序

### 环境推荐
> php5.5+

> mysql 5.6+

> 打开rewrite

### 安装步骤

1.创建 txspider数据库(默认编码utf8mb4),并导入 update/txspider.sql

2.在 data目录下创建 conf/database.php 文件,内容如下:
```php
<?php

return [
    // 数据库类型
    'type'           => 'mysql',
    // 服务器地址
    'hostname'       => 'localhost',
    // 数据库名
    'database'       => '你的数据库名',
    // 用户名
    'username'       => '你的数据库用户名',
    // 密码
    'password'       => '你的数据库密码',
    // 端口
    'hostport'       => '3306',
    // 数据库编码默认采用utf8
    'charset'        => 'utf8mb4',
    // 数据库表前缀
    'prefix'         => 'cmf_',
    "authcode" => 'CviMdXkZ3vUxyJCwNt',
];
```
更改为你的数据库信息

3.把 public目录做为网站根目录,入口文件在 public/index.php

4.后台 你的域名/admin
用户名/密码:admin/111111
