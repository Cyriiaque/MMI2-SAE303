<?php
require_once "Controller.php";
require_once "Repository/PriceRepository.php" ;

class PriceController extends Controller {

    private PriceRepository $price;

    public function __construct(){
        $this->price = new PriceRepository();
    }

   
    protected function processGetRequest(HttpRequest $request) {
        $id = $request->getId("id");
        if ($id){
            $p = $this->price->find($id);
            return $p==null ? false :  $p;
        }
        else{
            return $this->price->findAll();
        }
    }

    protected function processPostRequest(HttpRequest $request) {
        return false;
    }
   
}
?>