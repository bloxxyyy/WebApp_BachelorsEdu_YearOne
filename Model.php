<?php

/**
 * Abstracte laag om de Model te ondersteunen.
 * Voor nu gebruikt deze alleen DB op de database aan te roepen.
 * Class Model
 */
abstract class Model {

    /**
     * Returned een PDO object.
     * @return PDO|null
     */
    public function DB() {
        if (file_exists("Database.php")) {
            require_once("Database.php");
            return Database::LoadDb();
        }

        return null;
    }
}
