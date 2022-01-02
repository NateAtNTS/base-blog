<?php

namespace bb\controllers\api;

use Bb;
use bb\helpers\HyiiHelper;
use bb\helpers\UserHelper;
use bb\models\api\Post;
use bb\base\ApiController;
use bb\models\PostModel;

class PostsController extends ApiController
{

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    /*

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


    */

    /**
     * The vuejs web front end update post uses this api function; however, this api function turns on sessions for this
     * call and makes sure the user is logged in.
     *
     * @param $postId
     * @return array
     */
    public function actionUpdate($postId) {

        Bb::$app->user->enableSession = true;
        $user = UserHelper::loadUserInfo();

        if ($user == null) {
            return [
                "success" => false,
                "action" => "logout",
                "user" => $user
            ];
        } else {

            if (PostModel::updatePost($postId)) {
                return [
                    "success" => true,
                ];
            } else {
                return [
                    "success" => false,
                    "message" => "Update Failed"
                ];
            }

        }

    }

}