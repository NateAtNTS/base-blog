<?php

namespace bb\controllers;

use Bb;
use bb\base\PrivateWebController;
use bb\helpers\HyiiHelper;

class DashboardController extends PrivateWebController {

    public function actionIndex() {
        //Bb::dd($this->data);
        return $this->renderTemplate("dashboard/dashboard.twig", $this->data);
    }

}