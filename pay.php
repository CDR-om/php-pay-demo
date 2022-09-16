<?php
class Pay{

    private $log = false;

    public function __construct(){
        /* 打开日志 */
        if(defined('APP_LOG_WRITE') && APP_LOG_WRITE == true){
            $this->log = fopen('./log.txt','a');
        }
    }

    /**
     * @title    发送请求
     */
    public function curl($url,$method="post",$data=false,$contentType='application/json'){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        
        /* 返回响应结果 默认不输出 */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        /* POST 方法 */
        if($method == 'post' || $method == 'POST'){
            curl_setopt($ch,CURLOPT_POST,1);
            /* 请求参数以及数据格式化 */
            if($data && is_array($data)){
                switch($contentType){
                    /* application/json */
                    case 'application/json':
                        $data = json_encode($data);
                        curl_setopt($ch,CURLOPT_HTTPHEADER,[
                            "Content-Type:application/json",
                            "Content-Length:".strlen($data)
                        ]);
                        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
                        break;
                    /* application/x-www-form-urlencoded */
                    default:
                        curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($data));
                        break;
                }
            }
        }

        /* ==== 记录请求参数 非必要 ==== */
        if($this->log)  curl_setopt($ch,CURLINFO_HEADER_OUT,true);
        
        /* 执行请求 响应后立即关闭 */
        $output = curl_exec($ch);

        /* ==== 记录请求参数 非必要 ==== */
        if($this->log) fwrite($this->log,json_encode(curl_getinfo($ch)));

        /* 返回响应结果（或错误信息） */
        if(curl_errno($ch)){
            return curl_error($ch);
        }else{
            return $output;
        }
        curl_close($ch);

    }

    /**
     * @title    格式化签名
     */
    public function sign($data){
        if($data && is_array($data)){
            $result = '';

            /* 将空元素排除 */
            $data = array_filter($data);
            /* ASCII码 键名从小到大排序 */
            ksort($data);
            /* 拼接成字符串 */
            foreach($data as $key => $val){
                /* ==== 注意，代收代付等等接口的 “money” 字段 必须是保留两位小数的 string 类型 ==== */
                $result .= $key . '=' . $val . '&';
            }
            /* 拼接应用key */
            $result .= 'key=' . APP_KEY;
            /* md5 */
            $result = md5($result);
            /* 转换为大写 */
            $result = strtoupper($result);

            return $result;
        }else{
            return $data;
        }
    }

    /**
     * @title   请求参数加入签名
     */
    public function signData($data){
        if($data && is_array($data)){
            $data['sign'] = $this->sign($data);
            return $data;
        }else{
            return $data;
        }
    }

    /**
     * @desc    商户余额查询
     */
    public function balance(){
        $url = APP_REQUEST_URL . 'payAccount/balance';
        $data = $this->signData([
            "channel" => APP_CHANNEL,
            "randomStr" => md5(time()),
        ]);
        
        return $this->curl($url,'post',$data);
    }
}