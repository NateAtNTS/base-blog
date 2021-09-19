<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace bb\console\controllers;

use Bb;
use bb\console\Controller;
use bb\helpers\HyiiHelper;
use bb\migrations\Install;
use bb\migrations\InstallBlog;
use bb\migrations\InstallUserManagement;
use yii\db\config;



class UninstallController extends Controller
{
    // public $defaultAction = 'index';

    /**
     * This is only available in dev mode
     */
    public function actionIndex()
    {

        $userManagementResult = false;
        if (HyiiHelper::isUserFunctionalityInstalled() === true) {
            $userManagementUninstallMigration = new InstallUserManagement();
            $userManagementResult = $userManagementUninstallMigration->safeDown();
        }

        $blogResult = false;
        if (HyiiHelper::isBlogFunctionalityInstalled() === true) {
            $blogMigration = new InstallBlog();
            $blogResult = $blogMigration->safeDown();
        }

        $uninstallMigration = new Install();
        $result = $uninstallMigration->safeDown();


        if ($result && $userManagementResult && $blogResult) {
            Bb::_console("Removal Done! ");
        } else {
            Bb::_console("Removal Failed!");
        }
    }

}
