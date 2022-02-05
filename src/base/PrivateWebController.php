<?php

namespace bb\base;

use Bb;
use bb\helpers\HyiiHelper;
use bb\base\WebController;
use bb\helpers\UserHelper;

class PrivateWebController extends WebController {

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        Bb::$app->user->enableSession = true;

        if ($user == null) {
            
            if (Bb::$app->requestedRoute == 'user/check-username/') {                

                return json_encode([
                    "success" => false,
                    "message" => "logout"
                ]);
                
            } else {
                $this->redirect("/admin/login");
            }
            
        }
    }

}