<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Customers.php");

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
    public function getStatByCustomer($customerId){
        $req = $this->cnx->prepare("
            SELECT Movies.genre, COUNT(*) as total_watched
            FROM Movies
            LEFT JOIN Sales ON Movies.id = Sales.movie_id AND Sales.customer_id = :customerId
            LEFT JOIN Rentals ON Movies.id = Rentals.movie_id AND Rentals.customer_id = :customerId
            WHERE Sales.customer_id IS NOT NULL OR Rentals.customer_id IS NOT NULL
            GROUP BY Movies.genre
            ORDER BY total_watched DESC;
        ");
        $req->bindParam(':customerId', $customerId, PDO::PARAM_INT);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_OBJ);
    }
}