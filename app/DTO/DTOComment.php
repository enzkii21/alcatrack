<?php
namespace App\DTO;


class DTOComment{
    public $dto_comment;

    /**
     * Get the value of dto_comment
     */ 
    public function getDto_comment()
    {
        return $this->dto_comment;
    }

    /**
     * Set the value of dto_comment
     *
     * @return  self
     */ 
    public function setDto_comment($dto_comment)
    {
        $this->dto_comment = $dto_comment;

        return $this;
    }
}


?>