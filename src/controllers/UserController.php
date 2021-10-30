<?php

namespace bb\controllers;

use Bb;
use bb\helpers\HyiiHelper;
use bb\helpers\UserHelper;
use bb\models\UserModel;
use bb\base\PrivateWebController;
use yii\base\BaseObject;

class UserController extends PrivateWebController
{

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }


    public function actionAdd()
    {
        UserHelper::logoutIfNotAdmin($this);

        $user = new UserModel();

        if (HyiiHelper::isPost("firstName")) {

            //Bb::dd($_POST);

            if ($user->load(Bb::$app->request->post(), '') && $user->add()) {
                $this->redirect("/user/list");
            }
        } else {
            $this->data['user']['id'] = "";
            $this->data['user']['firstname'] = "";
            $this->data['user']['lastname'] = "";
            $this->data['user']['username'] = "";
            $this->data['user']['email'] = "";
            $this->data['user']['admin'] = "";
            $this->data['user']['active'] = "";
            return $this->renderTemplate("users/add.twig", $this->data);
        }

    }

    public function actionUpdate($id)
    {
        UserHelper::logoutIfNotAdmin($this);

        /**
         * Check to see if there is a post and handle it if there is
         */
        if (HyiiHelper::isPost('id')) {
            $currentUser = UserModel::findOne($id);
            $updatedUser = HyiiHelper::getPost();
            if (isset($updatedUser['password'])) {
                if ($updatedUser['password'] != "") {
                    $updatedUser['password'] = Bb::$app->getSecurity()->generatePasswordHash($updatedUser['password']);
                } else {
                    unset($updatedUser['password']);
                }
            }
            $currentUser->attributes = $updatedUser;
            $currentUser->save();
            $this->data['userUpdated'] = true;

        }

        $user = UserHelper::loadUserInfo($id);

        //Bb::dd($user);
        if ($user !== null) {
            $this->data['user'] = $user;
            return $this->renderTemplate("users/view.twig", $this->data);
        } else {

            /**
             * Since the user was not found, redirect back to the user list
             */
            $this->redirect("/user/list");
        }
    }


    public function actionCheckUsername()
    {
        Bb::$app->request->parsers = [ 'application/json' => 'yii\web\JsonParser'];
        $bUsernameExists = UserModel::find()
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
        if (HyiiHelper::isPost("firstName")) {
            $status = static::updateUser();
            $this->data['userUpdated'] = true;
            if ($status) {
                $this->data['userUpdateStatus'] = true;
            } else {
                $this->data['userUpdateStatus'] = false;
            }

            $this->data['user'] = UserHelper::loadUserInfo($this->data['user']['id']);

        }

        return $this->renderTemplate("users/profile.twig", $this->data);
    }

    /**
     * Gives a list of users as well as the opportunity to add a new user
     */
    public function actionList()
    {
        UserHelper::logoutIfNotAdmin($this);

        /**
         * Get unapproved users
         */
        $this->data['unapproved_users'] = UserModel::getUsers('N');

        /**
         * Get approved users
         */
        $this->data['users'] = $users = UserModel::getUsers();

        return $this->renderTemplate("users/list.twig", $this->data);

    }


    public function actionApproval($type, $id)
    {
        UserHelper::logoutIfNotAdmin($this);

        $user = UserModel::findOne($id);

        if ($user !== null) {
            if ($type === "yes") {
                $user->approved = 'Y';
            } else {
                $user->approved = 'D';
            }
            $user->save();
        }
        $this->redirect("/user/list");
    }

    private static function updateUser()
    {

        $user = new UserModel();
        if ($user->load(Bb::$app->request->post(), '') && $user->updateUser()) {
            return true;
        } else {
            return false;
        }
    }

} // class
