<?php

/**
 * Abstracte laag om Controllers te ondersteunen.
 * Class Controller
 */
abstract class Controller {

    // Het laden van html.
    public function View(string $name, array $args = []) {
        if (file_exists("Views/{$name}.php"))
            require_once ("Views/{$name}.php");
    }

    // Het laden van Model objecten.
    public function Model(string $name) {
        if (file_exists("Models/{$name}.php")) {
            require_once ("Models/{$name}.php");
            return new $name();
        }

        return null;
    }
}
