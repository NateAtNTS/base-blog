<?php

namespace bb\models\api;

use Bb;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Image\Box;

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
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
        ];
    }


    public function upload():array
    {
        if ($this->validate()) {
            $filename = $this->imageFile->baseName . '_temp.' . $this->imageFile->extension;
            $filenameFinal = $this->imageFile->baseName . '_1200x1200.' . $this->imageFile->extension;
            $fullFilePath = $this->privateAssetPath . DIRECTORY_SEPARATOR . $filename;
            $fullFilePathFinal = $this->privateAssetPath . DIRECTORY_SEPARATOR . $filenameFinal;

            $this->imageFile->saveAs($fullFilePath);

            $image = Image::getImagine();

            $image
                ->open($fullFilePath)
                ->thumbnail(new Box(1200, 1200))
                ->save($fullFilePathFinal, ['quality' => 70]);

            unlink($fullFilePath);
            return [ "success" => true, "message" => ""];
        } else {
            return [ "success" => false, "message" => "Failure to validate"];
        }

    } // function

} // class