<?php

namespace App\DTO;

class DTOALumni{
    public $dto_alumni;

    /**
     * Get the value of dto_alumni
     */ 
    public function getDto_alumni()
    {
        return $this->dto_alumni;
    }

    /**
     * Set the value of dto_alumni
     *
     * @return  self
     */ 
    public function setDto_alumni($dto_alumni)
    {
        $this->dto_alumni = $dto_alumni;

        return $this;
    }
}
?>