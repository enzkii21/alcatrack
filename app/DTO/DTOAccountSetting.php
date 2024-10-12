<?php
namespace App\DTO;

class DTOAccountSetting{
    public $dto_account_setting;

    /**
     * Get the value of dto_account_setting
     */ 
    public function getDto_account_setting()
    {
        return $this->dto_account_setting;
    }

    /**
     * Set the value of dto_account_setting
     *
     * @return  self
     */ 
    public function setDto_account_setting($dto_account_setting)
    {
        $this->dto_account_setting = $dto_account_setting;

        return $this;
    }
}

?>