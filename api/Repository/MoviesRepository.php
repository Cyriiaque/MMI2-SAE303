<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Movies.php");

class MoviesRepository extends EntityRepository {

    public function __construct(){
        parent::__construct();
    }

    public function find(){
        // $req = $this->cnx->prepare("select * from Movies where id=:value ;");
        // $req->bindParam(':value', $id);
        // $req->execute();
        // $ans = $req->fetch(PDO::FETCH_OBJ);
        // if ($ans==false){
        //     return null;
        // }
        // else{
        //     $p = new Movies((array)$ans);
        //     $p->setId($ans->id);
        //     $p->setMovieTitle($ans->movie_title);
        //     $p->setGenre($ans->genre);
        //     $p->setReleaseDate($ans->release_date);
        //     $p->setDurationMinutes($ans->duration_minutes);
        //     return $p;
        // }
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

    public function getStatCurrentMonth(){
        $requete_sales = $this->cnx->prepare("SELECT SUM(purchase_price) FROM Sales WHERE MONTH(purchase_date) = MONTH(CURRENT_DATE()) AND YEAR(purchase_date) = YEAR(CURRENT_DATE());");
        $requete_sales->execute();

        $answer_sales = $requete_sales->fetchAll(PDO::FETCH_OBJ);

        $requete_rental = $this->cnx->prepare("SELECT SUM(rental_price) FROM Rentals WHERE MONTH(rental_date) = MONTH(CURRENT_DATE()) AND YEAR(rental_date) = YEAR(CURRENT_DATE());");
        $requete_rental->execute();
    
        $answer_rental = $requete_rental->fetchAll(PDO::FETCH_OBJ);
       
        return [$answer_sales,$answer_rental];
    }

    public function getStatRanking(){
        $req_sales = $this->cnx->prepare(" SELECT Movies.*, COUNT(*) as purchase_count FROM Movies INNER JOIN Sales ON Movies.id = Sales.movie_id WHERE purchase_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) GROUP BY Movies.id ORDER BY purchase_count DESC LIMIT 3;");
        $req_sales->execute();
        $ans_sales = $req_sales->fetchAll(PDO::FETCH_OBJ);
        
        $req_rentals = $this->cnx->prepare("SELECT Movies.*, COUNT(*) as rental_count FROM Movies INNER JOIN Rentals ON Movies.id = Rentals.movie_id WHERE rental_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) GROUP BY Movies.id ORDER BY rental_count DESC LIMIT 3;");
        $req_rentals->execute();
        $ans_rentals = $req_rentals->fetchAll(PDO::FETCH_OBJ);

        return [$ans_sales, $ans_rentals];
    }

    public function getStatHistory(){
        $req_sales = $this->cnx->prepare("SELECT DATE_FORMAT(purchase_date, '%Y-%m') as month, SUM(purchase_price) as total_sales FROM Sales WHERE purchase_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY DATE_FORMAT(purchase_date, '%Y-%m') ORDER BY month DESC LIMIT 6;");
        $req_sales->execute();
        $ans_sales = $req_sales->fetchAll(PDO::FETCH_OBJ);
    
        $req_rentals = $this->cnx->prepare("SELECT DATE_FORMAT(rental_date, '%Y-%m') as month, SUM(rental_price) as total_rentals FROM Rentals WHERE rental_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) GROUP BY DATE_FORMAT(rental_date, '%Y-%m') ORDER BY month DESC LIMIT 6;");
        $req_rentals->execute();
        $ans_rentals = $req_rentals->fetchAll(PDO::FETCH_OBJ);
    
        return [$ans_sales, $ans_rentals];
    }

    public function getStatHistoryByType(){
        $req_sales = $this->cnx->prepare("SELECT DATE_FORMAT(Sales.purchase_date, '%Y-%m') as month, Movies.genre,SUM(Sales.purchase_price) as total_sales FROM Sales JOIN Movies ON Sales.movie_id = Movies.id WHERE Sales.purchase_date >= DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH) GROUP BY month, Movies.genre ORDER BY month DESC, Movies.genre;");
        $req_sales->execute();
    
        $ans_sales = $req_sales->fetchAll(PDO::FETCH_OBJ);

        $req_rentals = $this->cnx->prepare("SELECT DATE_FORMAT(Rentals.rental_date, '%Y-%m') as month, Movies.genre, SUM(Rentals.rental_price) as total_rentals FROM Rentals JOIN Movies ON Rentals.movie_id = Movies.id WHERE Rentals.rental_date >= DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH) GROUP BY month, Movies.genre ORDER BY month DESC, Movies.genre;");
        $req_rentals->execute();
        
        $ans_rentals = $req_rentals->fetchAll(PDO::FETCH_OBJ);
        
        return [$ans_sales, $ans_rentals];
    }

    public function getStatHistoryById($id){
        $req_sales = $this->cnx->prepare("SELECT DATE_FORMAT(purchase_date, '%Y-%m') as month, SUM(purchase_price) as total_sales FROM Sales WHERE purchase_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND movie_id = :id GROUP BY DATE_FORMAT(purchase_date, '%Y-%m') ORDER BY month DESC LIMIT 6;");
        $req_sales->bindParam(':id', $id, PDO::PARAM_INT);
        $req_sales->execute();
        $ans_sales = $req_sales->fetchAll(PDO::FETCH_OBJ);
    
        $req_rentals = $this->cnx->prepare("SELECT DATE_FORMAT(rental_date, '%Y-%m') as month, SUM(rental_price) as total_rentals FROM Rentals WHERE rental_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND movie_id = :id GROUP BY DATE_FORMAT(rental_date, '%Y-%m') ORDER BY month DESC LIMIT 6;");
        $req_rentals->bindParam(':id', $id, PDO::PARAM_INT);
        $req_rentals->execute();
        $ans_rentals = $req_rentals->fetchAll(PDO::FETCH_OBJ);
    
        return [$ans_sales, $ans_rentals];
    }
}