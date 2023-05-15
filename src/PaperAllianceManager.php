<?php
namespace PaperAlliance;

use PaperAlliance\Model\FindCheckRecordModel;
use PaperAlliance\Model\FindCheckRecordsModel;
use PaperAlliance\Model\InquireRestMoneyModel;
use PaperAlliance\Model\PayInfoStatusModel;
use PaperAlliance\Model\PayOrderModel;
use PaperAlliance\Model\PreCreateMultiModel;
use PaperAlliance\Model\PreCreateOneModel;
use PaperAlliance\Model\ReUploadPaperModel;
use PaperAlliance\Model\ValidatePaperModel;
use PaperAlliance\Request\ApiRequest;

class PaperAllianceManager
{
    /**
     * 配置
     * @var Config
     */
    protected $config;

    private $apiRequest;

    private $headers= [];

    /**
     * 初始化配置
     * TaoWenManager constructor.
     * @param null $config
     */
    public function __construct($config = null)
    {
        if($config){
            $this->config = $config;
        }else{
            $this->config = new Config();
        }
        $this->apiRequest = new ApiRequest();
        if($this->config->isFakeCheck()){
            $this->headers[] = "ISDEBUG: 1";
        }
    }

    /**
     * 验证论文文件接口
     * @param PaperParams $paper
     * @param $jane_name
     * @return Result\ResultSuccess|Result\ResultFail
     * @throws \Exception
     */
    public function validatePaper(PaperParams $paper,$jane_name)
    {
        if(!in_array($jane_name,JaneNameEnum::getAllowableEnumValues()))throw new \Exception('Detection system does not exist.');
        $validatePaperModel = new ValidatePaperModel($this->config);
        $validatePaperModel->setTitle($paper->getTitle());
        $validatePaperModel->setAuthor($paper->getAuthor());
        $validatePaperModel->setContent($paper->getContent());
        $validatePaperModel->setJaneName($jane_name);
        $this->headers[] = "Accept: application/json";
        $this->headers[] = "Cache-Control: no-cache";
        $this->headers[] = "Content-type: application/json";
        if(!$paper->getPaperPath()){
            $validatePaperModel->setContentType('text');
        }else{
            $validatePaperModel->setFilename(pathinfo($paper->getPaperPath(),PATHINFO_BASENAME));
            $validatePaperModel->setContentType('base64_filebytes');
        }
        $result = $this->apiRequest->callContent($validatePaperModel,"post",$this->headers);
        return $result;
    }

    /**
     * 单篇上传
     * @param PaperParams $paper
     * @param $jane_name
     * @param $selling_data
     * @param string $scope
     * @param null $check_params
     * @return Result\ResultFail|Result\ResultSuccess
     * @throws \Exception
     */
    public function preCreateOne(PaperParams $paper,$jane_name,$selling_data,$scope='js',$check_params=null)
    {
        if(!in_array($jane_name,JaneNameEnum::getAllowableEnumValues()))throw new \Exception('Detection system does not exist.');
        $preCreateOneModel = new PreCreateOneModel($this->config);
        $preCreateOneModel->setTitle($paper->getTitle());
        $preCreateOneModel->setAuthor($paper->getAuthor());
        $preCreateOneModel->setContent($paper->getContent());
        $preCreateOneModel->setJaneName($jane_name);
        $preCreateOneModel->setSellingData($selling_data);
        $preCreateOneModel->setScope($scope);
        $preCreateOneModel->setCheckParams($check_params);
        $this->headers[] = "Accept: application/json";
        $this->headers[] = "Cache-Control: no-cache";
        $this->headers[] = "Content-type: application/json";
        if(!$paper->getPaperPath()){
            $preCreateOneModel->setContentType('text');
        }else{
            $preCreateOneModel->setFilename(pathinfo($paper->getPaperPath(),PATHINFO_BASENAME));
            $preCreateOneModel->setContentType('base64_filebytes');
        }
        //生成验签
        $nonce=microtime();
        $preCreateOneModel->setNonce($nonce);
        $preCreateOneModel->setSign($this->config->getSign($scope.$jane_name.$selling_data.$nonce));
        $result = $this->apiRequest->callContent($preCreateOneModel,"post",$this->headers);
        return $result;
    }

    /**
     * 单篇上传
     * @param $papers
     * @param $jane_name
     * @param $selling_data
     * @param string $scope
     * @param null $check_params
     * @return Result\ResultFail|Result\ResultSuccess
     * @throws \Exception
     */
    public function preCreateMulti($papers,$jane_name,$selling_data,$scope='js',$check_params=null)
    {
        if(!in_array($jane_name,JaneNameEnum::getAllowableEnumValues()))throw new \Exception('Detection system does not exist.');

        $preCreateMultiModel = new PreCreateMultiModel($this->config);
        $preCreateMultiModel->setJaneName($jane_name);
        $preCreateMultiModel->setSellingData($selling_data);
        $preCreateMultiModel->setScope($scope);
        $preCreateMultiModel->setCheckParams($check_params);
        $this->headers[] = "Accept: application/json";
        $this->headers[] = "Cache-Control: no-cache";
        $this->headers[] = "Content-type: application/json";
        $papersParams = [];
        /** @var PaperParams $paper */
        foreach ($papers as $paper){
            $params = [
                'title'=>$paper->getTitle(),
                'author'=>$paper->getAuthor(),
                'content'=>$paper->getContent(),
            ];
            if(!$paper->getPaperPath()){
                $params['content_type'] = 'text';
            }else{
                $params['filename'] = pathinfo($paper->getPaperPath(),PATHINFO_BASENAME);
                $params['content_type'] = 'base64_filebytes';
            }
            $papersParams[] =$params;
        }
        if(empty($papersParams))throw new \Exception('Please upload a paper.');
        $preCreateMultiModel->setPapers($papersParams);
        //生成验签
        $nonce=microtime();
        $preCreateMultiModel->setNonce($nonce);
        $preCreateMultiModel->setSign($this->config->getSign($scope.$jane_name.$selling_data.$nonce));
        $result = $this->apiRequest->callContent($preCreateMultiModel,"post",$this->headers);
        return $result;
    }


    /**
     * 支付定单
     * @param $pay_id
     * @param $pay_type
     * @return Result\ResultFail|Result\ResultSuccess
     */
    public function payOrder($pay_id,$pay_type)
    {
        $this->headers[] = "Accept: application/json";
        $this->headers[] = "Cache-Control: no-cache";
        $this->headers[] = "Content-type: application/json";
        $payOrderModel = new PayOrderModel($this->config);
        $payOrderModel->setPayId($pay_id);
        $payOrderModel->setPayType($pay_type);

        return $this->apiRequest->callContent($payOrderModel,"post",$this->headers);
    }

    /**
     * 查询订单状态
     * @param $oid
     * @return mixed
     */
    public function payInfoStatus($oid)
    {
        $this->headers[] = "Accept: application/json";
        $this->headers[] = "Cache-Control: no-cache";
        $this->headers[] = "content-type:application/json";
        $payInfoStatusModel = new PayInfoStatusModel($this->config);
        $payInfoStatusModel->setOid($oid);
        $payInfoStatusModel->setResourcePath();
        return $this->apiRequest->callContent($payInfoStatusModel,"get",$this->headers);
    }

    /**
     * 查询单条订单状态
     * @param $paper_id
     * @return mixed
     */
    public function findCheckRecord($paper_id)
    {
        $this->headers[] = "Accept: application/json";
        $this->headers[] = "Cache-Control: no-cache";
        $this->headers[] = "content-type:application/json";
        $findCheckRecordModel = new FindCheckRecordModel($this->config);
        $findCheckRecordModel->setPaperId($paper_id);
        $findCheckRecordModel->setResourcePath();
        return $this->apiRequest->callContent($findCheckRecordModel,"get",$this->headers);
    }

    /**
     * 查询多条订单状态
     * @param $oid
     * @param $pids
     * @return Result\ResultFail|Result\ResultSuccess
     */
    public function findCheckRecords($pids,$oid=null)
    {
        $this->headers[] = "Accept: application/json";
        $this->headers[] = "Cache-Control: no-cache";
        $this->headers[] = "content-type:application/json";
        $findCheckRecordsModel = new FindCheckRecordsModel($this->config);
        $findCheckRecordsModel->setOid($oid);
        $findCheckRecordsModel->setPids($pids);
        return $this->apiRequest->callContent($findCheckRecordsModel,"get",$this->headers);
    }

    /**
     * 重新提交方法
     * @param PaperParams $paper
     * @param $paper_id
     * @return Result\ResultFail|Result\ResultSuccess
     */
    public function reUploadPaper(PaperParams $paper,$paper_id)
    {
        $reUploadPaperModel = new ReUploadPaperModel($this->config);
        $reUploadPaperModel->setTitle($paper->getTitle());
        $reUploadPaperModel->setAuthor($paper->getAuthor());
        $reUploadPaperModel->setContent($paper->getContent());
        $this->headers[] = "Accept: application/json";
        $this->headers[] = "Cache-Control: no-cache";
        $this->headers[] = "Content-type: application/json";
        if(!$paper->getPaperPath()){
            $reUploadPaperModel->setContentType('text');
        }else{
            $reUploadPaperModel->setFilename(pathinfo($paper->getPaperPath(),PATHINFO_BASENAME));
            $reUploadPaperModel->setContentType('base64_filebytes');
        }
        $reUploadPaperModel->setPaperId($paper_id);
        $reUploadPaperModel->setResourcePath();
        return $this->apiRequest->callContent($reUploadPaperModel,"post",$this->headers);
    }

    /**
     * 查询用户余额
     * @return Result\ResultFail|Result\ResultSuccess
     */
    public function inquireRestMoney()
    {
        $this->headers[] = "Accept: application/json";
        $this->headers[] = "Cache-Control: no-cache";
        $this->headers[] = "content-type:application/json";
        $inquireRestMoneyModel = new InquireRestMoneyModel($this->config);
        //生成验签
        $nonce=microtime();
        $inquireRestMoneyModel->setNonce($nonce);
        $inquireRestMoneyModel->setSign($this->config->getSign($nonce));
        return $this->apiRequest->callContent($inquireRestMoneyModel,"get",$this->headers);
    }
}




















