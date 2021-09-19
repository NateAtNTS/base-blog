<?php

namespace bb\base;

use Bb;
use bb\helpers\HyiiHelper;
use bb\base\WebController;

class PrivateWebController extends WebController {

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        Bb::$app->user->enableSession = true;

        if (HyiiHelper::getUser() == "") {
            
            if (Bb::$app->requestedRoute == 'user/check-username/') {                

                return json_encode([
                    "success" => false,
                    "message" => "logout"
                ]);
                
            } else {
                $this->redirect("/login");
            }
            
        }
    }

}