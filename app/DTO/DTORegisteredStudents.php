<?php
namespace App\DTO;


class DTORegisteredStudents{
    public $dto_students;

    /**
     * Get the value of dto_students
     */ 
    public function getDto_students()
    {
        return $this->dto_students;
    }

    /**
     * Set the value of dto_students
     *
     * @return  self
     */ 
    public function setDto_students($dto_students)
    {
        $this->dto_students = $dto_students;

        return $this;
    }
}

?>