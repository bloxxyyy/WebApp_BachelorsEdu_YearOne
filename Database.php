<?php

/**
 * De database connectie
 * Class Database
 */
class Database {

    // zorgen dat Database niet geïnitialiseerd kan worden.
    private function __construct() {}

    /**
     * Het laden van de database. geeft een PDO object terug aan de models die dit aanroepen.
     * @return PDO
     */
    public static function loadDb() : PDO {
        $hostname = "iproject18.ip.aimsites.nl,1301";
        $dbname = "iproject18";
        $username = "iproject18";
        $pw = "73ekvS7LTUpTAU4d1XUMIhj72HBh5Wvp";
        $dbh = new PDO ("sqlsrv:Server=$hostname;Database=$dbname;ConnectionPooling=0", "$username", "$pw");
        $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        return $dbh;
    }
}
