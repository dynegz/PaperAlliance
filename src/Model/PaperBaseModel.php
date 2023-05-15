<?php

namespace PaperAlliance\Model;

class PaperBaseModel extends BaseModel
{
    private $title;
    private $author;
    private $content;
    private $content_type;
    private $filename;
    private $jane_name;

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->postParams['title'] = $title;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        $this->postParams['author'] = $author;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        $this->postParams['content'] = $content;
    }

    /**
     * @param mixed $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        $this->postParams['filename'] = $filename;
    }

    /**
     * @param mixed $content_type
     */
    public function setContentType($content_type)
    {
        $this->content_type = $content_type;
        $this->postParams['content_type'] = $content_type;
    }

    /**
     * @param mixed $jane_name
     */
    public function setJaneName($jane_name)
    {
        $this->jane_name = $jane_name;
        $this->postParams['jane_name'] = $jane_name;
    }

    public function setResourcePath(){}
}