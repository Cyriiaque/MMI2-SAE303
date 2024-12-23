<?php
require_once "Controller.php";
require_once "Repository/MoviesRepository.php" ;

class MoviesController extends Controller {

    private MoviesRepository $movies;

    public function __construct(){
        $this->movies = new MoviesRepository();
    }

   
    protected function processGetRequest(HttpRequest $request) {
        $stat=$request->getParam("stat");

        if ($stat=='currentmonth'){
            $p= $this->movies->getStatCurrentMonth();
            return $p==null ? false :  $p;
        }

        else if ($stat=='ranking'){
            $p = $this->movies->getStatRanking();
            return $p==null ? false :  $p;
        }
        else if ($stat=='history'){
            $p = $this->movies->getStatHistory();
            return $p==null ? false :  $p;
        }
        else if ($stat=='historybytypesales'){
            $p = $this->movies->getStatHistoryByTypeSales();
            return $p==null ? false :  $p;
        }
        else if ($stat=='historybytyperentals'){
            $p = $this->movies->getStatHistoryByTypeRentals();
            return $p==null ? false :  $p;
        }
        else if ($stat=='historybyid'){
            $movieId = $request->getParam("id");
            if ($movieId == null) {
                return false;
            }
            $p = $this->movies->getStatHistoryById($movieId);
            return $p == null ? false : $p;
        }
        else if ($stat=='gendernumber'){
            $movieId = $request->getParam("id");
            if ($movieId == null) {
                return false;
            }
            $p = $this->movies->getStatGenderNumber($movieId);
            return $p == null ? false : $p;
        }
        else if ($stat=='all'){
            $p = $this->movies->findAll();
            return $p==null ? false :  $p;
        }
        else if ($stat=='gigaoctets'){
            $p = $this->movies->getStatGigaoctets();
            return $p==null ? false :  $p;
        }
    }

    protected function processPostRequest(HttpRequest $request) {
        return false;
    }
   
}
?>