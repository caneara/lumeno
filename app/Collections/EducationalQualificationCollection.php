<?php

namespace App\Collections;

use App\Models\School;
use App\Types\Collection;

class EducationalQualificationCollection extends Collection
{
    /**
     * The items within the collection.
     *
     */
    protected function source() : array
    {
        return [
            (object) ['id' => School::QUALIFICATION_STUDYING,         'degree' => false, 'name' => 'Currently studying'],
            (object) ['id' => School::QUALIFICATION_CERTIFICATE,      'degree' => false, 'name' => 'School Certificate / Diploma'],
            (object) ['id' => School::QUALIFICATION_ASSOCIATE_DEGREE, 'degree' => true,  'name' => 'Associate Degree'],
            (object) ['id' => School::QUALIFICATION_BACHELOR_DEGREE,  'degree' => true,  'name' => 'Bachelor Degree'],
            (object) ['id' => School::QUALIFICATION_MASTERS_DEGREE,   'degree' => true,  'name' => 'Master Degree'],
            (object) ['id' => School::QUALIFICATION_DOCTORAL_DEGREE,  'degree' => true,  'name' => 'Doctoral Degree'],
        ];
    }

    /**
     * Filter the repository to only include degree-based qualifications.
     *
     */
    public function onlyDegrees() : static
    {
        return $this->filter(fn($item) => $item->degree)->values();
    }
}
