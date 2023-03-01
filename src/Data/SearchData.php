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

    /**
     * @var string;
     */
    public $campus  ;

    /**
     * @var string A "Y-m-d" formatted value
     * @Assert\DateTime()
     */
    public $dateFrom;

    /**
     * @var string A "Y-m-d" formatted value
     * @Assert\DateTime()
     */
    public $dateTo;

    /**
     * @var Sortie[]
     */
    public $sorties =[];

}