<?php

namespace PaperAlliance\Model;


class PreCreateMultiModel extends BaseModel
{
    private $jane_name;
    private $selling_data;
    private $check_params;
    private $scope;
    private $nonce;
    private $sign;
    private $papers=[];

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

    /**
     * @param array $papers
     */
    public function setPapers($papers)
    {
        $this->papers = $papers;
        $this->postParams['papers'] = $papers;
    }

    /**
     * @param mixed $jane_name
     */
    public function setJaneName($jane_name)
    {
        $this->jane_name = $jane_name;
        $this->postParams['jane_name'] = $jane_name;
    }

    public function setResourcePath()
    {
        $this->resourcePath = "/checkorder/preCreateMulti";
    }

}