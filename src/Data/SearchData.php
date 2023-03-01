<?php

namespace App\Data;


use App\Entity\Campus;
use App\Entity\Sortie;
use Symfony\Component\Validator\Constraints as Assert;

class SearchData
{
    /**
     * @var string
     */
    public $q ='';

    public ?Campus $campus = null ;

    public ?\DateTime $dateFrom = null;

    public ?\DateTime $dateTo = null;


}