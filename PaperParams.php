<?php

namespace PaperAlliance;

class PaperParams {
	protected $content;
	protected $paperPath;
	protected $title;
	protected $author;
	protected $checkParams;

	public function __construct()
	{
	}
	public function getContent() {
		return $this->content;
	}
	public function setContent($content) {
		$this->content = $content;
		return $this;
	}
	public function getPaperPath() {
		return $this->paperPath;
	}
	public function setPaperPath($paperPath) {
        if(!file_exists($paperPath))throw new \Exception('Upload file does not exist.');
		$this->paperPath = $paperPath;
		$this->content = base64_encode(file_get_contents($paperPath));
		return $this;
	}
	public function getTitle() {
		return $this->title;
	}
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	public function getAuthor() {
		return $this->author;
	}
	public function setAuthor($author) {
		$this->author = $author;
		return $this;
	}
    public function setCheckParams($checkParams)
    {
        $this->checkParams = $checkParams;
        return $this;
    }
    public function getCheckParams()
    {
        return $this->checkParams;
    }

}

?>