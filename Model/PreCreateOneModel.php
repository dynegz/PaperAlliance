<?php
namespace PaperAlliance\Model;

class PreCreateOneModel extends PaperBaseModel
{

    private $selling_data;
    private $check_params;
    private $scope;
    private $nonce;
    private $sign;

    /**
     * @param mixed $selling_data
     */
    public function setSellingData($selling_data)
    {
        $this->selling_data = $selling_data;
        $this->postParams['selling_data'] = $selling_data;
    }

    /**
     * @param mixed $check_params
     */
    public function setCheckParams($check_params)
    {
        $this->check_params = $check_params;
        $this->postParams['check_params'] = $check_params;
    }

    /**
     * @param mixed $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
        $this->postParams['scope'] = $scope;
    }

    /**
     * @param mixed $nonce
     */
    public function setNonce($nonce)
    {
        $this->nonce = $nonce;
        $this->getParams['nonce'] = $nonce;
    }

    /**
     * @param mixed $sign
     */
    public function setSign($sign)
    {
        $this->sign = $sign;
        $this->getParams['sign'] = $sign;
    }

    public function setResourcePath()
    {
        $this->resourcePath = "/checkorder/preCreateOne";
    }

}