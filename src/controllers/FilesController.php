<?php

namespace bb\controllers;

use Bb;
use bb\base\PrivateWebController;
use bb\models\AssetModel;
use yii\helpers\BaseFileHelper;

class FilesController extends PrivateWebController
{

    private $privateAssetPath;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->privateAssetPath = Bb::getAlias("@secure_files_folder");
    }

    public function actionView($assetId)
    {
        $asset = AssetModel::findOne($assetId);

        if ($asset !== null) {
            $extension = $asset['type'];
        } else {
            exit;
        }

        $filenameFinal = $assetId . "." . $extension;
        $fullFilePathFinal = $this->privateAssetPath . DIRECTORY_SEPARATOR . $filenameFinal;

        $file_mime = BaseFileHelper::getMimeType($fullFilePathFinal);
        header('Content-Type: ' . $file_mime);
        header('Content-Length: ' . filesize($fullFilePathFinal));
        readfile($fullFilePathFinal);

    }


}