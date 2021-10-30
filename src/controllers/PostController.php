<?php

namespace bb\controllers;

use Bb;
use bb\base\PrivateWebController;
use bb\models\PostModel;

class PostController extends PrivateWebController {

    public function actionView($postId)
    {
        $this->data['post'] = PostModel::findOne($postId);
        return $this->renderTemplate("post/view.twig", $this->data);
    }

}