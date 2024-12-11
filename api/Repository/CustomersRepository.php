<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Customers.php");
require_once("Class/Movies.php");

class CustomersRepository extends EntityRepository {

    public function __construct(){
        parent::__construct();
    }

    public function find(){
        return false;
    }

    public function findAll(){
        return false;
    }

    public function save($entity){
        return false;
    }

    public function delete($entity){
        return false;
    }

    public function update($entity){
        return false;
    }

    public function getStatByCountry(){
        $req_sales = $this->cnx->prepare("
            SELECT Customers.country, SUM(Sales.purchase_price) as total_sales
            FROM Customers
            INNER JOIN Sales ON Customers.id = Sales.customer_id
            GROUP BY Customers.country
            ORDER BY total_sales DESC;
        ");
        $req_sales->execute();
        $ans_sales = $req_sales->fetchAll(PDO::FETCH_OBJ);
        
        $req_rentals = $this->cnx->prepare("
            SELECT Customers.country, SUM(Rentals.rental_price) as total_rentals
            FROM Customers
            INNER JOIN Rentals ON Customers.id = Rentals.customer_id
            GROUP BY Customers.country
            ORDER BY total_rentals DESC;
        ");
        $req_rentals->execute();
        $ans_rentals = $req_rentals->fetchAll(PDO::FETCH_OBJ);
    
        return [$ans_sales, $ans_rentals];
    }

    // getStatByCustomer a pour consigne: Pour un client sélectionné, visualiser tous les films qu’il a regardés (donc loués ou achetés) par genre.
    public function getStatByCustomer($id){
        $req_customer = $this->cnx->prepare("select id,first_name,last_name from Customers where id=:value;");
        $req_customer->bindParam(':value', $id);
        $req_customer->execute();
        $ans_customer = $req_customer->fetch(PDO::FETCH_OBJ);

        $req_sales = $this->cnx->prepare("select Movies.* from Movies join Sales on Movies.id=Sales.movie_id where customer_id=:value;");
        $req_sales->bindParam(':value', $id);
        $req_sales->execute();
        $ans_sales = $req_sales->fetchAll(PDO::FETCH_OBJ);

        $req_rentals = $this->cnx->prepare("select Movies.* from Movies join Rentals on Movies.id=Rentals.movie_id where customer_id=:value;");
        $req_rentals->bindParam(':value', $id);
        $req_rentals->execute();
        $ans_rentals = $req_rentals->fetchAll(PDO::FETCH_OBJ);

        if ($ans_customer==false){
            return null;
        }
        else{
            $customer = new Customers((array)$ans_customer);
            $customer->setId($ans_customer->id);
            $customer->setFirstName($ans_customer->first_name);
            $customer->setLastName($ans_customer->last_name);

            $sales = [];
            foreach ($ans_sales as $sale) {
                $movie = new Movies((array)$sale);
                $movie->setId($sale->id);
                $movie->setMovieTitle($sale->movie_title);
                $movie->setGenre($sale->genre);
                $movie->setReleaseDate($sale->release_date);
                $movie->setDurationMinutes($sale->duration_minutes);
                $movie->setRating($sale->rating);
                $sales[] = $movie;
            }

            $rentals = [];
            foreach ($ans_rentals as $rental) {
                $movie = new Movies((array)$rental);
                $movie->setId($rental->id);
                $movie->setMovieTitle($rental->movie_title);
                $movie->setGenre($rental->genre);
                $movie->setReleaseDate($rental->release_date);
                $movie->setDurationMinutes($rental->duration_minutes);
                $movie->setRating($rental->rating);
                $rentals[] = $movie;
            }

            return [$customer, $sales, $rentals];
        }
    }
}