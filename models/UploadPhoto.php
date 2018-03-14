<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadPhoto extends Model
{
    /**
     * @var UploadedFile
     */
    public $photo;
    
    public function upload()
    {
       
        if ($this->validate()) {
            
            $this->photo->saveAs(Yii::getAlias('@web') . 'upload/'. $this->photo->baseName . '.' . $this->photo->extension);
            return true;
        } else {
            return false;
        }
    }
}