<?php

/**
 * Functies om Authorizatie mee te checken.
 * Class Authorization
 */
class Authorization {
    /**
     * Check of de Mailbox gezet is voor een ingelogde gebruiker.
     * @return bool
     */
    public static function IsLoggedIn() : bool {
        return !empty($_SESSION["Mailbox"]) && !is_null($_SESSION["Mailbox"]);
    }

    /**
     * Check of de hash sessie voor het maken van gebruikers is geactiveerd.
     * @return bool
     */
    public static function IsHashActivated() : bool {
        return !empty($_SESSION["Hash"]) && !is_null($_SESSION["Hash"]);
    }
}
