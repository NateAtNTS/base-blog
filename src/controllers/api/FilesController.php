<?php

namespace bb\controllers\api;

use Bb;
use bb\base\ApiController;
use bb\helpers\HyiiHelper;
use bb\models\api\FileModel;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;
use yii\web\UploadedFile;

class FilesController extends ApiController
{

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function actionUpload()
    {

        if (Bb::$app->request->isPost) {
            $model = new FileModel();

            $model->imageFile = UploadedFile::getInstanceByName('fileUpload');

            // BaseApi::dd($model->imageFile);

            if ($model->upload()) {
                return [
                    "success" => true
                ];
                //echo "file uploaded Successfully.";
                //exit;
            } else {
                return [
                    "success" => false
                ];
                //echo "there was a problem uploading the file";
                //exit;
            }

        } else {
            echo '
<!DOCTYPE html>
<html>
<body>

<form action="https://hyii.test/api/files/upload/" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
';
            exit;
        }

    }

}