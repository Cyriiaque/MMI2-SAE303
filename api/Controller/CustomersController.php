<?php
require_once "Controller.php";
require_once "Repository/CustomersRepository.php" ;

class CustomersController extends Controller {

    private CustomersRepository $customers;

    public function __construct(){
        $this->customers = new CustomersRepository();
    }

   
    protected function processGetRequest(HttpRequest $request) {
        $stat=$request->getParam("stat");
        $id=$request->getParam("id");

        if ($stat=='country'){
            $p= $this->customers->getStatByCountry();
            return $p==null ? false :  $p;
        }
        if ($stat=='movies'){
            $p= $this->customers->getStatByCustomer($id);
            return $p==null ? false :  $p;
        }
    }

    protected function processPostRequest(HttpRequest $request) {
        return false;
    }
   
}
?>