<?php

namespace bb\helpers;

use Bb;

Class UserHelper {

    /**
     * Check to see if the logged in user is an admin
     */
    public static function isAdmin() {

        if (Bb::$app->user->identity->admin != "N") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the user id of the person logged in
     *
     * @return int
     */
    public static function userId()
    {
        return Bb::$app->user->identity->id;
    }

}



