<?php

namespace bb\controllers;

use Bb;
use bb\base\PrivateWebController;
use bb\models\PostModel;

class PostController extends PrivateWebController
{

    public function actionUpdate($postId)
    {
        $this->data['post'] = $post = PostModel::findOne($postId);

        if ($post == null) {
            $this->redirect("/dashboard");
        }

        return $this->renderTemplate("post/update.twig", $this->data);
    }

}