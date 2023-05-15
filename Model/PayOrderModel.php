<?php

namespace PaperAlliance\Model;


class PayOrderModel extends BaseModel
{
    private $pay_id;
    private $pay_type;

    /**
     * @param mixed $pay_id
     */
    public function setPayId($pay_id)
    {
        $this->pay_id = $pay_id;
        $this->postParams['pay_id'] = $pay_id;
    }

    /**
     * @param mixed $pay_type
     */
    public function setPayType($pay_type)
    {
        $this->pay_type = $pay_type;
        $this->postParams['pay_type'] = $pay_type;
    }

    public function setResourcePath(){
        $this->resourcePath = "/checkorder/payOrder";
    }

    /**
     * @return string
     */
    public function getPostParams()
    {
        return json_encode($this->postParams,true);
    }

}