<?php

namespace bb\controllers;

use bb\base\PublicWebController;

class HelloController extends PublicWebController  {

    public function actionIndex() {

        $data = [
            "title" => "My test page",
            "body" => "Hello World"
        ];

        return $this->renderTemplate("hello/index.twig", $data);

    }

}