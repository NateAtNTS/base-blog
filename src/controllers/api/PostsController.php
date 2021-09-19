<?php

namespace bb\controllers\api;

use Bb;
use bb\helpers\HyiiHelper;
use bb\models\api\Post;
use bb\base\ApiController;

class PostsController extends ApiController
{

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        return [
            "success" => true,
            "posts" => Post::getPosts(),
        ];

    }


    public function actionAdd()
    {
        $post = new Post();

        if ($post->load(Bb::$app->request->post(), '') && $post->add()) {
            return [
                "success" => true,
                "id" => $post->id,
            ];
        } else {
            return ["success" => false];
        }
    }

    public function actionGetPost($id = -1)
    {
        HyiiHelper::checkParam($id, -1, "Missing Post ID");
        $post = Post::findOne($id);
        HyiiHelper::nullCheck($post, "Unable to find the specified post");


        return [
            "success" => true,
            "title" => $post->title,
        ];
    }

}