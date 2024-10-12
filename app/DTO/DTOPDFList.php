<?php

namespace App\DTO;


class DTOPDFList{
    public $dto_pdflist;

    /**
     * Get the value of dto_pdflist
     */ 
    public function getDto_pdflist()
    {
        return $this->dto_pdflist;
    }

    /**
     * Set the value of dto_pdflist
     *
     * @return  self
     */ 
    public function setDto_pdflist($dto_pdflist)
    {
        $this->dto_pdflist = $dto_pdflist;

        return $this;
    }
}


?>