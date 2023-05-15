<?php
namespace PaperAlliance\Result;

class ResultSuccess
{
    /**
     * 回复信息
     * @var array
     */
    private $data;

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}









