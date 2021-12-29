<?php

namespace App\Entity;

class SearchBar
{

    /*
    * @var int | null
    */
    private $maxPrice;

    /*
    * @var int | null
    */
    private $minPrice;



    /**
     * Get | null
     *
     * @return  int
     */
    public function getMaxPrice()
    {
        return $this->maxPrice;
    }

    /**
     * Set | null
     *
     * @param  int  $maxPrice  | null
     *
     * @return  self
     */
    public function setMaxPrice(int $maxPrice)
    {
        $this->maxPrice = $maxPrice;

        return $this;
    }

    /**
     * Get | null
     *
     * @return  int
     */
    public function getMinPrice()
    {
        return $this->minPrice;
    }

    /**
     * Set | null
     *
     * @param  int  $minPrice  | null
     *
     * @return  self
     */
    public function setMinPrice(int $minPrice)
    {
        $this->minPrice = $minPrice;

        return $this;
    }
}
