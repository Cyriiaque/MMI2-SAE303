<?php

class Movies implements JsonSerializable {
   
    protected $id;
    protected $movie_title;


    public function __construct($data) {
        $this->id = $data['id'];
        $this->movie_title = $data['movie_title'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMovieTitle(): string
    {
        return $this->movie_title;
    }

    public function JsonSerialize(): mixed{
        return [
            'id' => $this->id,
            'movie_title' => $this->movie_title
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
    public function setMovieTitle($movie_title): self
    {
        $this->movie_title = $movie_title;
        return $this;
    }
}