<?php

namespace bb\models;

use Bb;
use yii\db\ActiveRecord;
use bb\helpers\HyiiHelper;
use bb\models\PostElementsModel;

class PostModel extends ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%posts}}';
    }

    public static function getPost($postId)
    {
        $post = static::findOne($postId);

        if ($post != null) {
            $p['id'] = $post->id;
            $p['title'] = $post->title;
            $p['elements'] = static::getPostElements($postId);
        }
        return $p;
    }

    public static function updatePost($postId) {
        $post = HyiiHelper::getPost();
        $postToUpdate = static::findOne($postId);

        if ($postToUpdate != null) {
            $postToUpdate->title = $post['title'];
            $postToUpdate->save();
        }

        if (isset($post['elements'])) {
            $elements = $post['elements'];

            foreach ($elements as $e) {
                if ($e['id'] == -1) {
                    $newE = new PostElementsModel();
                    $newE->post = $e['post'];
                    $newE->order = $e['order'];
                    $newE->data = $e['data'];
                    $newE->type = $e['type'];
                    $newE->save();
                } else {
                    $currentE = PostElementsModel::findOne($e['id']);
                    if ($currentE != null) {
                        $currentE->post = $e['post'];
                        $currentE->order = $e['order'];
                        $currentE->data = $e['data'];
                        $currentE->type = $e['type'];
                        $currentE->save();
                    } // if current
                } // if else id
            } // foreach
        } // if isset post

        return true;
    }

    public static function getPostElements($postId)
    {
        $elements = HyiiHelper::query()
            ->select("*")
            ->from("{{%post_elements}}")
            ->where("trashed = 'N'")
            ->andWhere("post=$postId")
            ->orderBy("order ASC")
            ->all();

        //Bb::dd($elements);
        return $elements;
    }

}