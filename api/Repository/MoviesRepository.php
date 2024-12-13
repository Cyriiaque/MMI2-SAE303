<?php

require_once("Repository/EntityRepository.php");
require_once("Class/Movies.php");

class MoviesRepository extends EntityRepository {

    public function __construct(){
        parent::__construct();
    }

    public function find(){
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
        $requete_sales = $this->cnx->prepare("SELECT SUM(purchase_price) AS purchase FROM Sales WHERE MONTH(purchase_date) = MONTH(CURRENT_DATE()) AND YEAR(purchase_date) = YEAR(CURRENT_DATE());");
        $requete_sales->execute();
        $answer_sales = $requete_sales->fetch(PDO::FETCH_OBJ);

        $requete_rental = $this->cnx->prepare("SELECT SUM(rental_price) AS rental FROM Rentals WHERE MONTH(rental_date) = MONTH(CURRENT_DATE()) AND YEAR(rental_date) = YEAR(CURRENT_DATE());");
        $requete_rental->execute();
        $answer_rental = $requete_rental->fetch(PDO::FETCH_OBJ);
       
        return [(object) ['purchase' => $answer_sales->purchase, 'rental' => $answer_rental->rental]];
    }

    public function getStatRanking(){
        $req_sales = $this->cnx->prepare(" SELECT Movies.movie_title, COUNT(*) as purchase_count FROM Movies INNER JOIN Sales ON Movies.id = Sales.movie_id WHERE purchase_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) GROUP BY Movies.id ORDER BY purchase_count DESC LIMIT 3;");
        $req_sales->execute();
        $ans_sales = $req_sales->fetchAll(PDO::FETCH_OBJ);
        
        $req_rentals = $this->cnx->prepare("SELECT Movies.movie_title, COUNT(*) as rental_count FROM Movies INNER JOIN Rentals ON Movies.id = Rentals.movie_id WHERE rental_date >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) GROUP BY Movies.id ORDER BY rental_count DESC LIMIT 3;");
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

    public function getStatHistoryByTypeSales(){
        $req_sales = $this->cnx->prepare("SELECT DATE_FORMAT(Sales.purchase_date, '%Y-%m') as month, Movies.genre,SUM(Sales.purchase_price) as total FROM Sales JOIN Movies ON Sales.movie_id = Movies.id WHERE Sales.purchase_date >= DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH) GROUP BY month, Movies.genre ORDER BY month DESC, Movies.genre;");
        $req_sales->execute();
    
        $ans_sales = $req_sales->fetchAll(PDO::FETCH_OBJ);
        foreach ($ans_sales as $sale) {
            $sale->total = floatval($sale->total);
        }
        
        return $ans_sales;
    }

    public function getStatHistoryByTypeRentals(){

        $req_rentals = $this->cnx->prepare("SELECT DATE_FORMAT(Rentals.rental_date, '%Y-%m') as month, Movies.genre, SUM(Rentals.rental_price) as total FROM Rentals JOIN Movies ON Rentals.movie_id = Movies.id WHERE Rentals.rental_date >= DATE_SUB(CURRENT_DATE(), INTERVAL 5 MONTH) GROUP BY month, Movies.genre ORDER BY month DESC, Movies.genre;");
        $req_rentals->execute();
        
        $ans_rentals = $req_rentals->fetchAll(PDO::FETCH_OBJ);
        foreach ($ans_rentals as $rental) {
            $rental->total = floatval($rental->total);
        }
        
        return $ans_rentals;
    }

    public function getStatHistoryById($id){
        $months = [];
        for ($i = 0; $i < 6; $i++) {
            $months[date('Y-m', strtotime("-$i month"))] = (object) ['month' => date('Y-m', strtotime("-$i month")), 'total_sales' => 0, 'total_rentals' => 0];
        }

        $req_sales = $this->cnx->prepare("SELECT DATE_FORMAT(purchase_date, '%Y-%m') as month, SUM(purchase_price) as total_sales FROM Sales WHERE purchase_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND movie_id = :id GROUP BY DATE_FORMAT(purchase_date, '%Y-%m') ORDER BY month DESC;");
        $req_sales->bindParam(':id', $id, PDO::PARAM_INT);
        $req_sales->execute();
        $ans_sales = $req_sales->fetchAll(PDO::FETCH_OBJ);

        foreach ($ans_sales as $sale) {
            if (isset($months[$sale->month])) {
            $months[$sale->month]->total_sales = floatval($sale->total_sales);
            }
        }

        $req_rentals = $this->cnx->prepare("SELECT DATE_FORMAT(rental_date, '%Y-%m') as month, SUM(rental_price) as total_rentals FROM Rentals WHERE rental_date >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND movie_id = :id GROUP BY DATE_FORMAT(rental_date, '%Y-%m') ORDER BY month DESC;");
        $req_rentals->bindParam(':id', $id, PDO::PARAM_INT);
        $req_rentals->execute();
        $ans_rentals = $req_rentals->fetchAll(PDO::FETCH_OBJ);

        foreach ($ans_rentals as $rental) {
            if (isset($months[$rental->month])) {
            $months[$rental->month]->total_rentals = floatval($rental->total_rentals);
            }
        }

        return array_values($months);
    }

    public function getStatGenderNumber($id){
        $req = $this->cnx->prepare("
            SELECT Movies.genre, COUNT(*) as count
            FROM Movies
            LEFT JOIN Sales ON Movies.id = Sales.movie_id AND Sales.customer_id = :value
            LEFT JOIN Rentals ON Movies.id = Rentals.movie_id AND Rentals.customer_id = :value
            WHERE Sales.customer_id IS NOT NULL OR Rentals.customer_id IS NOT NULL
            GROUP BY Movies.genre
        ");
        $req->bindParam(':value', $id);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_OBJ);
    }

    public function findAll(){
        $req_movie = $this->cnx->prepare("select id,movie_title from Movies");
        $req_movie->execute();
        $ans_movie = $req_movie->fetchAll(PDO::FETCH_OBJ);

        $movies = [];
        foreach ($ans_movie as $movie) {
            $p = new Movies((array)$movie);
            $p->setId($movie->id);
            $p->setMovieTitle($movie->movie_title);
            array_push($movies, $p);
        }

        return $movies;
    }

    public function getStatGigaoctets(){
        $req = $this->cnx->prepare("SELECT
        c.country AS Pays,
        DATE_FORMAT(r.rental_date, '%Y-%m') AS Mois,
        ROUND(SUM(m.duration_minutes / 60 * 2.7), 2) AS Consommation_GB FROM Rentals r JOIN
        Customers c ON r.customer_id = c.id JOIN
        Movies m ON r.movie_id = m.id WHERE
        r.rental_date >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH) GROUP BY
        c.country, DATE_FORMAT(r.rental_date, '%Y-%m')ORDER BY Mois, c.country DESC;");
        $req->execute();
        return $req->fetchAll(PDO::FETCH_OBJ);
    }
}