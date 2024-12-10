<?php

class Price implements JsonSerializable {
   
    protected $rental_date;
    protected $rental_price;
    protected $purchase_date;
    protected $purchase_price;

    public function __construct($data) {
        $this->rental_date = $data['rental_date'];
        $this->rental_price = $data['rental_price'];
        $this->purchase_date = $data['purchase_date'];
        $this->purchase_price = $data['purchase_price'];
    }

    public function getRentalDate(): string
    {
        return $this->rental_date;
    }

    public function getRentalPrice(): float
    {
        return $this->rental_price;
    }

    public function getPurchaseDate(): string
    {
        return $this->purchase_date;
    }

    public function getPurchasePrice(): float
    {
        return $this->purchase_price;
    }

    public function JsonSerialize(): mixed{
        return [
            'rental_date' => $this->rental_date,
            'rental_price' => $this->rental_price,
            'purchase_date' => $this->purchase_date,
            'purchase_price' => $this->purchase_price
        ];
    }

    /**
     *@return  self
     */
    public function setRentalDate($rental_date): self
    {
        $this->rental_date = $rental_date;
        return $this;
    }

    /**
     *@return  self
     */
    public function setRentalPrice($rental_price): self
    {
        $this->rental_price = $rental_price;
        return $this;
    }

    /**
     *@return  self
     */
    public function setPurchaseDate($purchase_date): self
    {
        $this->purchase_date = $purchase_date;
        return $this;
    }

    /**
     *@return  self
     */
    public function setPurchasePrice($purchase_price): self
    {
        $this->purchase_price = $purchase_price;
        return $this;
    }
}