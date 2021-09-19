<?php

namespace bb\models\api;

use Bb;
use yii\base\Model;
use yii\web\UploadedFile;

class FileModel extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    private $publicAssetPath;

    private $privateAssetPath;

    public function __construct($config = [])
    {
        parent::__construct($config);
        $this->publicAssetPath = Bb::getAlias("@public_asset_folder_path");
        $this->privateAssetPath = Bb::getAlias("@secure_files_folder");
    }

    public function rules():array
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }


    public function upload():bool
    {
        //echo $this->publicAssetPath;
        if ($this->validate()) {
            $filename = $this->imageFile->baseName . '.' . $this->imageFile->extension;

            $this->imageFile->saveAs($this->privateAssetPath . DIRECTORY_SEPARATOR . $filename);
            return true;
        } else {
            return false;
        }
    }
}