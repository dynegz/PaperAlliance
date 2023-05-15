<?php

namespace  PaperAlliance\Result;

class ResultFail
{
    public function __construct($errorMsg='未找到错误',$errorCode=4444){
        $this->setErrorCode($errorCode);
        $this->setErrorMag($errorMsg);
    }

    /**
     * 错误信息
     * @var string
     */
    private $errorMag;

    /**
     * 错误编码
     * @var int
     */
    private $errorCode;

    /**
     * @param int $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param string $errorMag
     */
    public function setErrorMag($errorMag)
    {
        $this->errorMag = $errorMag;
    }

    /**
     * @return string
     */
    public function getErrorMag()
    {
        return $this->errorMag;
    }
}

















