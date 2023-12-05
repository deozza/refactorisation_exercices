<?php

namespace App\DTO;

class BuyerInfosDTO {
    private string $buyerName;
    private string $buyerAddress;
    private string $buyerPhone;
    private string $buyerEmail;

    public function getBuyerName(): string
    {
        return $this->buyerName;
    }

    public function setBuyerName(string $buyerName): self
    {
        $this->buyerName = $buyerName;

        return $this;
    }

    public function getBuyerAddress(): string
    {
        return $this->buyerAddress;
    }

    public function setBuyerAddress(string $buyerAddress): self
    {
        $this->buyerAddress = $buyerAddress;

        return $this;
    }

    public function getBuyerPhone(): string
    {
        return $this->buyerPhone;
    }

    public function setBuyerPhone(string $buyerPhone): self
    {
        $this->buyerPhone = $buyerPhone;

        return $this;
    }

    public function getBuyerEmail(): string
    {
        return $this->buyerEmail;
    }

    public function setBuyerEmail(string $buyerEmail): self
    {
        $this->buyerEmail = $buyerEmail;

        return $this;
    }
    
}