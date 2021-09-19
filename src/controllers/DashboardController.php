<?php

namespace bb\controllers;

use Bb;
use bb\base\PrivateWebController;
use bb\helpers\HyiiHelper;

class DashboardController extends PrivateWebController {

    public function actionIndex() {
        //BaseApi::dd(Helper::getUser());
        return $this->renderTemplate("dashboard/dashboard.twig");
    }

}