<?php
namespace PaperAlliance\Model;


class PayInfoStatusModel extends BaseModel
{
    private $oid;

    /**
     * @param mixed $oid
     */
    public function setOid($oid)
    {
        $this->oid = $oid;
    }

    public function setResourcePath(){
        $this->resourcePath = "/checkorder/".$this->oid."/status";
    }
}