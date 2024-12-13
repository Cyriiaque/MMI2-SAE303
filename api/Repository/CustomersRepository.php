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
            SELECT Customers.country, SUM(Sales.purchase_price) as total
            FROM Customers
            INNER JOIN Sales ON Customers.id = Sales.customer_id
            GROUP BY Customers.country
            ORDER BY total DESC;
        ");
        $req_sales->execute();
        $ans_sales = $req_sales->fetchAll(PDO::FETCH_OBJ);

        foreach ($ans_sales as $sale) {
            $sale->total = floatval($sale->total);
        }

        $req_rentals = $this->cnx->prepare("
            SELECT Customers.country, SUM(Rentals.rental_price) as total
            FROM Customers
            INNER JOIN Rentals ON Customers.id = Rentals.customer_id
            GROUP BY Customers.country
            ORDER BY total DESC;
        ");
        $req_rentals->execute();
        $ans_rentals = $req_rentals->fetchAll(PDO::FETCH_OBJ);

        foreach ($ans_rentals as $rental) {
            $rental->total = floatval($rental->total);
        }
    
        return [$ans_sales, $ans_rentals];
    }

    public function getStatCustomers(){
        $req_customer = $this->cnx->prepare("select id,first_name,last_name from Customers");
        $req_customer->execute();
        $ans_customer = $req_customer->fetchAll(PDO::FETCH_OBJ);

        $customers = [];
        foreach ($ans_customer as $customer) {
            $p = new Customers((array)$customer);
            $p->setId($customer->id);
            $p->setFirstName($customer->first_name);
            $p->setLastName($customer->last_name);
            array_push($customers, $p);
        }

        return $customers;
    }
}