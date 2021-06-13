<?php

class ErrorController extends Controller {
    public function Pagina() {
        $this->View("404");
        $this->View("Default/footer");
    }
}
