<?php

namespace bb\controllers;

use Bb;
use bb\base\PrivateWebController;
use bb\helpers\HyiiHelper;

class DashboardController extends PrivateWebController {

    public function actionIndex() {

        $this->data['posts'] = HyiiHelper::query()
            ->select("*")
            ->from("{{%posts}}")
            ->where("trashed ='N'")
            ->orderBy("date DESC")
            ->all();

        //Bb::dd($this->data);
        return $this->renderTemplate("dashboard/dashboard.twig", $this->data);
    }

}