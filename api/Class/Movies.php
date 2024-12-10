<?php

class Movies implements JsonSerializable {
   
    protected $id;
    protected $movie_title;
    protected $genre;
    protected $release_date;
    protected $duration_minutes;
    protected $rating;


    public function __construct($data) {
        $this->id = $data['id'];
        $this->movie_title = $data['movie_title'];
        $this->genre = $data['genre'];
        $this->release_date = $data['release_date'];
        $this->duration_minutes = $data['duration_minutes'];
        $this->rating = $data['rating'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMovieTitle(): string
    {
        return $this->movie_title;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function getReleaseDate(): string
    {
        return $this->release_date;
    }

    public function getDurationMinutes(): int
    {
        return $this->duration_minutes;
    }

    public function getRating(): string
    {
        return $this->rating;
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

    /**
     *@return  self
     */
    public function setGenre($genre): self
    {
        $this->genre = $genre;
        return $this;
    }

    /**
     *@return  self
     */
    public function setReleaseDate($release_date): self
    {
        $this->release_date = $release_date;
        return $this;
    }

    /**
     *@return  self
     */
    public function setDurationMinutes($duration_minutes): self
    {
        $this->duration_minutes = $duration_minutes;
        return $this;
    }

    /**
     *@return  self
     */
    public function setRating($rating): self
    {
        $this->rating = $rating;
        return $this;
    }
}