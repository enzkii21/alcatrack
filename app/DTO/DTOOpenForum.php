<?php

namespace App\DTO;

class DTOOpenForum{
    public $dto_forum;

    /**
     * Get the value of dto_forum
     */ 
    public function getDto_forum()
    {
        return $this->dto_forum;
    }

    /**
     * Set the value of dto_forum
     *
     * @return  self
     */ 
    public function setDto_forum($dto_forum)
    {
        $this->dto_forum = $dto_forum;

        return $this;
    }
}


?>