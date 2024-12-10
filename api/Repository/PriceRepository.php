<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Price.php");

class PriceRepository extends EntityRepository {

    public function __construct(){
        parent::__construct();
    }

    public function find($id){
        // $req = $this->cnx->prepare("select Rentals.rental_date , Rentals.rental_price , Sales.purchase_date, Sales.purchase_price from Rentals , Sales where id=:value ;");
        // $req->bindParam(':value', $id);
        // $req->execute();
        // $ans = $req->fetch(PDO::FETCH_OBJ);
        // if ($ans==false){
        //     return null;
        // }
        // else{
        //     $p = new Price((array)$ans);
        //     $p->setRentalDate($ans->rental_date);
        //     $p->setRentalPrice($ans->rental_price);
        //     $p->setPurchaseDate($ans->purchase_date);
        //     $p->setPurchasePrice($ans->purchase_price);
        //     return $p;
        // }
        return false;
    }

    public function findAll(){
        // $requete = $this->cnx->prepare("select Rentals.rental_date , Rentals.rental_price , Sales.purchase_date, Sales.purchase_price from Rentals , Sales");
        $requete = $this->cnx->prepare("SELECT (SELECT SUM(purchase_price) FROM Sales WHERE MONTH(purchase_date) = MONTH(CURRENT_DATE()) AND YEAR(purchase_date) = YEAR(CURRENT_DATE())) AS total_sales, (SELECT SUM(rental_price) FROM Rentals WHERE MONTH(rental_date) = MONTH(CURRENT_DATE()) AND YEAR(rental_date) = YEAR(CURRENT_DATE())) AS total_rentals;");
        $requete->execute();
    
        $answer = $requete->fetchAll(PDO::FETCH_OBJ);
       
        return $answer;
    }

    // public function findAll($limit = 100, $offset = 0){
    //     $requete = $this->cnx->prepare("SELECT Rentals.rental_date, Rentals.rental_price, Sales.purchase_date, Sales.purchase_price FROM Rentals, Sales LIMIT :limit OFFSET :offset;");
    //     $requete->bindParam(':limit', $limit, PDO::PARAM_INT);
    //     $requete->bindParam(':offset', $offset, PDO::PARAM_INT);
    //     $requete->execute();
    
    //     $answer = $requete->fetchAll(PDO::FETCH_OBJ);
    
    //     $res = [];
        
    //     foreach($answer as $obj){
    //         $p = new Price((array)$obj);
    //         $p->setRentalDate($obj->rental_date);
    //         $p->setRentalPrice($obj->rental_price);
    //         $p->setPurchaseDate($obj->purchase_date);
    //         $p->setPurchasePrice($obj->purchase_price);
    //         array_push($res, $p);
    //     }
       
    //     return $res;
    // }

    public function save($entity){
        return false;
    }

    public function delete($entity){
        return false;
    }

    public function update($entity){
        return false;
    }
}