<?php
include './pay.php';

/* 本地请求参数写入日志文件方便调试，非必要 */
define('APP_LOG_WRITE',false);
/* API地址 */
define('APP_REQUEST_URL','http://b9a.lilianaalam.com/api/');

/* 填入您的商户号 和 Key */
define('appKey','填入您自己的商户号');
define('appKey','填入您自己的商户Key');

$pay = new Pay();

/* 商户余额查询 */
print $pay->balance();

