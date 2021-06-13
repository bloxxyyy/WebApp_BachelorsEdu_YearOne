<?php

class App {

    /**
     * For loading controllers and methods given by the index.php file.
     * @param string $controller
     * @param string $method
     */
    public function __construct(string $controller, string $method, array $args) {

        // set een temp variable
        $oldArgs = $args;

        // als gebruiker sessie bestaat
        if (array_key_exists('Gebruikersnaam', $_SESSION)) {
            $gebruiker = $_SESSION['Gebruikersnaam'];
            require_once("Models/MaakVeilingModel.php");
            $veilingModel = new MaakVeilingModel();

            // set de verkoper's variable
            $isVerkoper = $veilingModel->isGebruikerVerkoper($gebruiker);
        } else {
            $isVerkoper = false;
        }

        // zet de 4 eerste rubrieken in de header.
        require_once ("Models/RubriekModel.php");
        $rubriekModel = new RubriekModel();
        $rubrieken = $rubriekModel->GetRubrieken(4);

        // maar de args aan en stop deze in de header.
        $args = ["itemlists" => $rubrieken, "Loggedin" => Authorization::IsLoggedIn(), "isVerkoper" => $isVerkoper];
        require_once ("Views/Default/header.php");

        // pak de oude argumenten.
        $args = $oldArgs;

        // Pak de juiste controller.
        if (file_exists("Controllers/{$controller}.php")) {
            require_once("Controllers/{$controller}.php");
            if (method_exists($controller, $method)) { // als de aangeleverde methode bestaat.
                $class = new $controller();
                call_user_func(array($class, $method), $args); // roep de functie aan.
                die;
            }
        }

        // Als de controller methode combinatie niet werkte roep de Error Controller aan.
        require_once("Controllers/ErrorController.php");
        if (file_exists("Controllers/ErrorController.php")) {
            require_once("Controllers/ErrorController.php");
            $class = new ErrorController();
            call_user_func(array($class, "Pagina"), $args);
        }
        else echo "404"; // Als alles faald.
    }
}
