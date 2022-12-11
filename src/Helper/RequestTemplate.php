<?php

namespace Piash\Helper;

class RequestTemplate
{

    protected $className;

    private $path;

    public function __construct(string $className, string $path)
    {
        $this->className = $className;
        $this->path = rtrim($path, "/") . "/" . $className .".php";
    }

    public function render()
    {
        $myfile = fopen($this->path, "w") or die("Unable to open file!");
        $text = <<<TEXT
            <?php
            
            namespace App\\Request;
                
            use Symfony\\Component\\Validator\\Constraints as Assert;
            use Piash\\Request\\BaseRequest;
                
            class $this->className extends BaseRequest
            {
                
            }
            TEXT;
        $data = preg_replace('/^ +/m', '', $text);
        fwrite($myfile, $data);
        fclose($myfile);
    }
}
