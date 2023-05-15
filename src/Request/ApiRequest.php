<?php
namespace PaperAlliance\Request;

use PaperAlliance\Model\BaseModel;
use PaperAlliance\Result\ResultSuccess;
use PaperAlliance\Result\ResultFail;

class ApiRequest {

    private $hostUrl = 'http://api.checkpass.net/v3';

    /**
     * 接口地址
     * @var string
     */
    protected $apiUrl='';

    protected $curlTimeOut = 30;

    /**
     *  请求入口
     * @param BaseModel $baseModel
     * @param $methods
     * @param $withCookie
     * @param array $headers
     * @return ResultFail|ResultSuccess
     */
    public function callContent(BaseModel $baseModel,$methods="post",$headers=[],$withCookie=false)
    {
        $this->apiUrl = $this->hostUrl.$baseModel->getResourcePath();
        $ret = $this->requestHttp($baseModel->getGetParams(),$baseModel->getPostParams(),$methods,$headers,$withCookie);
        return $this->resultData($ret);
    }

    /**
     * 提取结果
     * @param $ret
     * @return ResultFail|ResultSuccess
     */
    public function resultData($ret){
        try{
            if($ret instanceof ResultFail)return $ret;
            $data = json_decode($ret,true);
            if(isset($data['data']) and (empty($data['code']) or in_array($data['code'],['pay.result.view']))){
                $resultSuccess = new ResultSuccess();
                $resultSuccess->setData($data);
                return $resultSuccess;
            }else{
                return new ResultFail((string)$data['codeMsg'],(int)$data['code']);
            }
        }catch (\Exception $e){
            //todo:'出错'.$e->getMessage()写入日志
        }
        return new ResultFail('未知接口错误',5000);
    }

    /**
     * 数据发送
     * @param $getArgs
     * @param $postArgs
     * @param string $methods
     * @param array $headers
     * @param bool $withCookie
     * @return bool|ResultFail|string
     */
    protected function requestHttp($getArgs,$postArgs,$methods = 'post',$headers=array(),$withCookie = false){
        $ch = curl_init();
        $url = $this->apiUrl;
        //get数据
        if($getArgs){
            $getData = $this->convert($getArgs);
            if(stripos($this->apiUrl, "?") > 0)
            {
                $url .= "&$getData";
            }
            else
            {
                $url .= "?$getData";
            }
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        if(!empty($headers))curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // Set user agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'PaperAllianceV3');
        //post数据
        if($postArgs and $methods != 'get'){
            switch ($methods){
                case 'put':
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    break;
                default:
                    curl_setopt($ch, CURLOPT_POST, true);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS,$postArgs);
        }
        curl_setopt($ch,CURLOPT_HEADER, false);//设置不返回header
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,100);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_TIMEOUT, $this->curlTimeOut);

        if($withCookie) curl_setopt($ch, CURLOPT_COOKIEJAR, $_COOKIE);

        $r = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if($error) return new ResultFail("请求发生错误：".$error);
        return $r;
    }

    /**
     * 数据处理
     * @param $args
     * @return string
     */
    protected function convert(&$args)
    {
        $data = '';
        if (is_array($args))
        {
            foreach ($args as $key=>$val)
            {
                if (is_array($val))
                {
                    foreach ($val as $k=>$v)
                    {
                        $data .= $key.'['.$k.']='.rawurlencode($v).'&';
                    }
                }
                else
                {
                    $data .="$key=".rawurlencode($val)."&";
                }
            }
            return trim($data, "&");
        }
        return $args;
    }

}