<?php

/**
 * Class Veilingen
 * Om de rubrieken te tonen.
 */
class Rubrieken extends Controller {

    /**
     * @param null $args
     * Laad de rubrieken pagina in.
     */
    public function Pagina($args) {
        $rubriekModel = $this->Model("RubriekModel");
        $productModel = $this->Model("ProductModel");

        $urlHelper = $this->GetUrl($args);

        // set breadcrum if value is given.
        $breadcrum = [];
        if (is_numeric($urlHelper["currentRubriekId"])) {
            $breadcrum = array_reverse($rubriekModel->GetBreadcrum($urlHelper["currentRubriekId"]));
            $childRubrieken = $rubriekModel->GetRubriekenByRubriekId($urlHelper["currentRubriekId"]);
        } else {
            $childRubrieken = $rubriekModel->GetRubriekenByRubriekId(null);
        }

        // Hoofd rubrieken hebben nooit producten.
        $producten = [];
        if ($urlHelper["currentRubriekId"] != null) {
            if (is_numeric($urlHelper["currentRubriekId"]) && $urlHelper["currentRubriekId"] <= 2147483646)
                $producten = $productModel->GetRecursionProductenByRubriekId($urlHelper["currentRubriekId"]);
        }

        $productArraysOnPage = 12;
        $productOutput = [];
        $productAmount = 0;

        if (!empty($producten)) {
            $productPaginasation = $this->GetPaginasation($urlHelper["productpage"], $productArraysOnPage, $producten);
            $productOutput = $productPaginasation["output"];
            $productAmount = $productPaginasation["amount"];
        }

        $this->View("Producten/Rubrieken", ["pageAmount" => $productAmount, "Producten" => $productOutput, "Rubrieken" => $childRubrieken, "breadcrumList" => $breadcrum, "urlArgs" => $urlHelper]);
        $this->View("Default/footer");
    }

    /**
     * @param $args
     * Helper voor de URL bar om makkelijk urls aan te roepen.
     * @return array
     */
    private function GetUrl($args) {
        $productPageId = (count($args) > 0) ? $args[0] : 1;
        $id =            (count($args) > 1) ? $args[1] : null;

        if (!is_numeric($productPageId)) $productPageId = 1;
        if (!is_numeric($productPageId)) $productPageId = 1;

        return [
            "productpage" => $productPageId,
            "currentRubriekId" => $id,
            "helperUrl" => $productPageId . "/"
        ];
    }

    /**
     * Get paginisation by products
     * @param int $currentPageNr
     * @param int $ItemsOnPage
     * @param array $products
     * @return array
     */
    private function GetPaginasation(int $currentPageNr, int $ItemsOnPage, array $products) : array {
        $currentPageNr = ($currentPageNr < 1) ? 1 : $currentPageNr;
        $StartIndex = ($currentPageNr - 1) * $ItemsOnPage;
        $lastIndex = (($currentPageNr - 1) * $ItemsOnPage) + ($ItemsOnPage - 1);
        $StartIndex = ($StartIndex < 0) ? 0 : $StartIndex;
        $lastIndex = ($lastIndex > count($products)) ? count($products) : $lastIndex;

        $output = array_slice($products, $StartIndex, $ItemsOnPage);
        $amount = count($products) / $ItemsOnPage;
        if ($output == null) $output = [];
        return ["output" => $output, "amount" => $amount];
    }
}
