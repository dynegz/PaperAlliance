<?php
namespace PaperAlliance\Model;


class FindCheckRecordModel extends BaseModel
{
    private $paper_id;

    /**
     * @param mixed $paper_id
     */
    public function setPaperId($paper_id)
    {
        $this->paper_id = $paper_id;
    }

    public function setResourcePath(){
        $this->resourcePath = "/checkrecord/".$this->paper_id;
    }
}