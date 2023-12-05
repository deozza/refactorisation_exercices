<?php

namespace App\DTO;

class SellingInfosDTO {

    private \DateTime $dateOfBuild;

    private \DateTime $dateSold;

    private int $price;

    public function getDateOfBuild(): \DateTime
    {
        return $this->dateOfBuild;
    }

    public function setDateOfBuild(\DateTime $dateOfBuild): self
    {
        $this->dateOfBuild = $dateOfBuild;

        return $this;
    }

    public function getDateSold(): \DateTime
    {
        return $this->dateSold;
    }

    public function setDateSold(\DateTime $dateSold): self
    {
        $this->dateSold = $dateSold;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        if($price < 0){
            throw new \Exception('Price cannot be negative');
        }

        $this->price = $price;

        return $this;
    }

}