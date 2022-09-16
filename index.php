<?php
include './pay.php';

/* 本地请求参数写入日志文件方便调试，非必要 */
define('APP_LOG_WRITE',false);
/* API地址 */
define('APP_REQUEST_URL','http://b9a.lilianaalam.com/api/');
/* define('appKey','填入您自己的商户号'); */
define('APP_CHANNEL',156);
/* define('appKey','填入您自己的商户Key'); */
define('APP_KEY','kZ0IngihCILuXF245izaChO/FZ//f2DHtFLyxjdXvtnwKWl4mC+WlnK8kxiEs1Yo/NJdnMJwaN8qGLMqwaIHPw==');

$pay = new Pay();

/* 商户余额查询 */
print $pay->balance();

