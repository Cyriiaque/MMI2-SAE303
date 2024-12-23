<?php

class Customers implements JsonSerializable {
   
    protected $id;
    protected $first_name;
    protected $last_name;


    public function __construct($data) {
        $this->id = $data['id'];
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function JsonSerialize(): mixed{
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name
        ];
    }

    /**
     *@return  self
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     *@return  self
     */
    public function setFirstName($first_name): self
    {
        $this->first_name = $first_name;
        return $this;
    }

    /**
     *@return  self
     */
    public function setLastName($last_name): self
    {
        $this->last_name = $last_name;
        return $this;
    }
}