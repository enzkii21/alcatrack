<?php
namespace App\DTO;

class DTOCourse{
    public $dto_course;

    /**
     * Get the value of dto_course
     */ 
    public function getDto_course()
    {
        return $this->dto_course;
    }

    /**
     * Set the value of dto_course
     *
     * @return  self
     */ 
    public function setDto_course($dto_course)
    {
        $this->dto_course = $dto_course;

        return $this;
    }
}

?>