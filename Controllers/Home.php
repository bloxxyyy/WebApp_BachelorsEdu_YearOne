<?php

/**
 * Het tonen van de home pagina.
 * Class Home
 */
class Home extends Controller {

    // het laden van de pagina.
    public function Pagina() {

        // pak recenten producten
        $recentProducts = $this->LoadRecentProducts(6);

        // pak recenten rubrieken.
        $productsByRandomRubrieks = $this->LoadProductsByRandomRubrieks(4);

        $this->View("Home/RecentProducts", ["recentProducts" => $recentProducts]);
        $this->View("Home/RandomCat", ["productsByRandomRubrieks" => $productsByRandomRubrieks, "recentProducts" => $recentProducts]);
        $this->View("Home/RandomProducts", ["recentProducts" => $recentProducts]);
        $this->View("Default/footer");
    }

    /**
     * Load the most recent product by amount.
     * @param int $amount
     * @return array
     */
    private function LoadRecentProducts(int $amount) : array {
        $productModel = $this->Model("ProductModel");
        return $productModel->GetRecentProducts($amount);
    }

    /**
     * Load the most recent product by amount.
     * @param int $amount
     * @return array
     */
    private function LoadProductsByRandomRubrieks(int $amount) : array {
        $productModel = $this->Model("ProductModel");
        $rubriekModel = $this->Model("RubriekModel");
        $randomRubrieks = $rubriekModel->GetRandomRubrieks($amount);

        $array = [];
        foreach ($randomRubrieks as $randomRubriek) {
            array_push($array, [
                "rubriekNaam" => $randomRubriek["Rubrieknaam"],
                "product" => $productModel->GetRandomProductByRubriek($randomRubriek["Rubrieknummer"])
            ]);
        }

        return $array;
    }
}
