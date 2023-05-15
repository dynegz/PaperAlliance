<?php
namespace PaperAlliance\Model;


class FindCheckRecordsModel extends BaseModel
{
    private $oid;
    private $pids;

    /**
     * @param mixed $oid
     */
    public function setOid($oid)
    {
        $this->oid = $oid;
        $this->getParams['oid'] = $oid;
    }

    /**
     * @param mixed $pids
     */
    public function setPids($pids)
    {
        $this->pids = $pids;
        $this->getParams['pids'] = $pids;
    }

    public function setResourcePath(){
        $this->resourcePath = "/checkrecord";
    }
}