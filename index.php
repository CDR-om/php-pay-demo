<?php
include './pay.php';

/* 本地请求参数写入日志文件方便调试，非必要 */
define('APP_LOG_WRITE',false);
/* API地址 */
define('APP_REQUEST_URL','http://b9a.lilianaalam.com/api/');
/* 回调地址 */
define('APP_RETURN_URL','填入您的回调地址');

/* 填入您的商户号 和 Key */
#define('APP_CHANNEL','填入您自己的商户号');
#define('APP_KEY','填入您自己的商户Key');

$pay = new Pay();

/* 商户余额查询 */
# print $pay->balance();

/* 代收下单 */
print $pay->pay([
    '生成的唯一订单号',
    '（您的）平台会员账号',
    '（您的）平台会员姓名(支持中文)',
    '接入通道: cny | yhk1 | yhk2 (详见文档: 接入通道类型)',
    '2.00',
]);
