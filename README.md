# 格式化参数

生成签名
```
$this->sign(Array[])
```

#  php注意事项

代收、代付接口的 “money” 字段，要求为保留两位小数的 string 类型，如不慎传入integer、float 类型会导致 md5 结果与服务器不一致
