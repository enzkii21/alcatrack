<?php
namespace App\DTO;



class DTOImageList{
    public $dto_image;

    /**
     * Get the value of dto_image
     */ 
    public function getDto_image()
    {
        return $this->dto_image;
    }

    /**
     * Set the value of dto_image
     *
     * @return  self
     */ 
    public function setDto_image($dto_image)
    {
        $this->dto_image = $dto_image;

        return $this;
    }
}


?>