<?php
namespace \vendor\payment; 

/**
* @email 630104898@qq.com 
* @author zhaolx
* @date 2016-08-31
*/
class WeixinPay
{
    //支付配置
    public $config;
     
    //支付参数
    public $params;
     
    //统一下单url
    const POST_ORDER_URL = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
     
    //订单查询url
    const ORDER_QUERY_URL = 'https://api.mch.weixin.qq.com/pay/orderquery';
     
    /**
     * 创建微信js发起支付参数
     * @return array
     */
    public function createJsPayData()
    {
        $this->params['nonce_str'] = $this->getRandomStr();
        $this->params['sign'] = $this->sign();
         
        $xmlStr = $this->arrayToXml();
         
        $res = $this->postUrl(self::POST_ORDER_URL, $xmlStr);
        $res = $this->xmlToArray($res);
        if( $res['return_code'] == 'SUCCESS' && $res['result_code'] == 'SUCCESS' && $this->verifySignResponse($res) ) {
            $params = [
                'appId' => $this->params['appid'],
                'timeStamp' => (string)time(),
                'nonceStr' => $this->getRandomStr(),
                'package' => 'prepay_id='.$res['prepay_id'],
                'signType' => 'MD5'
            ];
             
            $this->params = $params;
            $this->params['paySign'] = $this->sign();
            return $this->params;
        }
        if($res['return_code'] == 'FAIL') {
            throw new \Exception("提交预支付交易单失败:{$res['return_msg']}");
        }
         
        throw new \Exception("提交预支付交易单失败，{$res['err_code']}:{$res['err_code']}");
    }
     
    /**
     * 验证异步通知
     * @return boolean
     */
    public function verifyNotify()
    {
        $this->params = $this->xmlToArray($this->params);
        if( empty($this->params['sign']) ) {
            return false;
        }
        $sign = $this->sign();
        return $this->params['sign'] == $sign;
    }
     
    /**
     * 取成功响应
     * @return string
     */
    public function getSucessXml()
    {
        $xml = '<xml>';
        $xml .= '<return_code><![CDATA[SUCCESS]]></return_code>';
        $xml .= '<return_msg><![CDATA[OK]]></return_msg>';
        $xml .= '</xml>';
        return $xml;
    }
     
    public function getFailXml()
    {
        $xml = '<xml>';
        $xml .= '<return_code><![CDATA[FAIL]]></return_code>';
        $xml .= '<return_msg><![CDATA[OK]]></return_msg>';
        $xml .= '</xml>';
        return $xml;
    }
     
    /**
     * 数组转成xml字符串
     * 
     * @return string
     */
    protected function arrayToXml()
    {
        $xml = '<xml>';
        foreach($this->params as $key => $value) {
            $xml .= "<{$key}>";
            $xml .= "<![CDATA[{$value}]]>";
            $xml .= "</{$key}>";
        }
        $xml .= '</xml>';
         
        return $xml;
    }
     
    /**
     * xml 转换成数组
     * @param string $xml
     * @return array
     */
    protected function xmlToArray($xml)
    {
        $xmlObj = simplexml_load_string(
                $xml,
                'SimpleXMLIterator',   //可迭代对象
                LIBXML_NOCDATA
        );
         
        $arr = [];
        $xmlObj->rewind(); //指针指向第一个元素
        while (1) {
            if( ! is_object($xmlObj->current()) )
            {
                break;
            }
            $arr[$xmlObj->key()] = $xmlObj->current()->__toString();
            $xmlObj->next(); //指向下一个元素
        }
         
        return $arr;
    }
     
    //验证统一下单接口响应
    protected function verifySignResponse($arr)
    {
        $tmpArr = $arr;
        unset($tmpArr['sign']);
        ksort($tmpArr);
        $str = '';
        foreach($tmpArr as $key => $value) {
            $str .= "$key=$value&";
        }
        $str .= 'key='.$this->config['key'];
         
        if($arr['sign'] == $this->signMd5($str)) {
            return true;
        }
        return false;
    }
     
     
    /**
     * 签名
     * 规则：
     * 先按照参数名字典排序
     * 用&符号拼接成字符串
     * 最后拼接上API秘钥，str&key=密钥
     * md5运算，全部转换为大写
     * 
     * @return string
     */
    protected function sign()
    {
        ksort($this->params);
        $signStr = $this->arrayToString();
        $signStr .= '&key='.$this->config['key'];
        if($this->config['signType'] == 'MD5') {
            return $this->signMd5($signStr);
        }        
         
        throw new \InvalidArgumentException('Unsupported sign method');
    }
     
    /**
     * 数组转成字符串
     * @return string
     */
    protected  function arrayToString()
    {
        $params = $this->filter($this->params);
        $str = '';
        foreach($params as $key => $value) {
            $str .= "{$key}={$value}&";
        }
         
        return substr($str, 0, strlen($str)-1);
    }
     
    /*
     * 过滤待签名数据，sign和空值不参加签名
     * 
     * @return array
     */
    protected function filter($params)
    {
        $tmpParams = [];
        foreach ($params as $key => $value) {
            if( $key != 'sign' && ! empty($value) ) {
                $tmpParams[$key] = $value;
            }
        }
         
        return $tmpParams;
    }
     
    /**
     * MD5签名
     * 
     * @param string $str 待签名字符串
     * @return string 生成的签名，最终数据转换成大写
     */
    protected function signMd5($str)
    {
        $sign = md5($str);
         
        return strtoupper($sign);
    }
     
    /**
     * 获取随机字符串
     * @return string 不长于32位
     */
    protected function getRandomStr()
    {
        return substr( rand(10, 999).strrev(uniqid()), 0, 15 );
    }
     
    /**
     * 通过POST方法请求URL
     * @param string $url
     * @param array|string $data post的数据
     *
     * @return mixed
     */
    protected function postUrl($url, $data) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); //忽略证书验证
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($curl);
        return $result;
    }
}
?>