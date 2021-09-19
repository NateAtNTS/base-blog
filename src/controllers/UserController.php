<?php

namespace bb\controllers;

use Bb;
use bb\helpers\HyiiHelper;
use bb\models\User;
use bb\base\PrivateWebController;

class UserController extends PrivateWebController
{

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    
    public function actionUpdate() {
        $user = new User();
        if ($user->load(Bb::$app->request->post(), '') && $user->updateUser()) {
            return ["success" => true];
        } else {
            return ["success" => false];
        }
    }


    public function actionAdd()
    {
        $user = new User();

        if ($user->load(Bb::$app->request->post(), '') && $user->add()) {
            return ["success" => true];
        } else {
            return ["success" => false];
        }
    }


    public function actionCheckUsername()
    {
        Bb::$app->request->parsers = [ 'application/json' => 'yii\web\JsonParser'];
        $bUsernameExists = User::find()
            ->where(["username" => Bb::$app->request->post("username", '')])
            ->count();

        if ($bUsernameExists > 0) {
            return json_encode([
                    "success" => true,
                    "message" => "not-unique"
                ]);
        }

        return json_encode([
            "success" => true,
            "message" => "unique"
        ]);
    }


    public function actionProfile() 
    {
        if (HyiiHelper::isPost("username")) {
            Bb::dd($_POST);
        } else {            
            $user = HyiiHelper::getUser();
            $this->data['user']['id'] = $user->id;
            $this->data['user']['firstname'] = $user->firstName;
            $this->data['user']['lastname'] = $user->lastName;
            $this->data['user']['username'] = $user->username;
            $this->data['user']['email'] = $user->email;
            $this->data['user']['admin'] = $user->admin;            
            return $this->renderTemplate("users/profile.twig", $this->data);
        }

    }

} // class
