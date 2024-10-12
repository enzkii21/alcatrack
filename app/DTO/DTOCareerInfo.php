<?php

namespace App\DTO;


class DTOCareerInfo{
    public $dto_careerinfo;

    /**
     * Get the value of dto_careerinfo
     */ 
    public function getDto_careerinfo()
    {
        return $this->dto_careerinfo;
    }

    /**
     * Set the value of dto_careerinfo
     *
     * @return  self
     */ 
    public function setDto_careerinfo($dto_careerinfo)
    {
        $this->dto_careerinfo = $dto_careerinfo;

        return $this;
    }
}

?>