<?php

namespace app\Entity;

use Doctrine\ORM\Mapping as ORM;

class Files
{
    /** 
     * @ORM\Column(type: 'string')
     */
    private $files;

    public function getFiles()
    {
        return $this->files;
    }

    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }
}