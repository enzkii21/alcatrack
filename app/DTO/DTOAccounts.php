<?php

namespace App\DTO;


class DTOAccounts{
    public $dto_accounts;

    /**
     * Get the value of dto_accounts
     */ 
    public function getDto_accounts()
    {
        return $this->dto_accounts;
    }

    /**
     * Set the value of dto_accounts
     *
     * @return  self
     */ 
    public function setDto_accounts($dto_accounts)
    {
        $this->dto_accounts = $dto_accounts;

        return $this;
    }
}


?>