<?php

namespace app\models;

use Yii;
use DateTime;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property string $name
 * @property string $created
 * @property int $user_id
 * @property int $priority
 * @property int $status
 * @property string $photo
 */
class Task extends \yii\db\ActiveRecord
{
    const NEWTASK = 0;
    const DONETASK = 1;
    const CANCELEDTASK = 2;
    const IMPORTANTTASK = 0;
    const UNIMPORTANTTASK = 1;

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'user_id'], 'required'],           
            [['priority', 'status'], 'integer'],
            [['name', 'user_id'], 'string', 'max' => 255],
            [['photo'], 'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created' => 'Created',
            'user_id' => 'User',
            'priority' => 'Priority',
            'status' => 'Status',
            'photo' => 'Photo',
        ];
    }
    /**
     * Get task status array
     * @return array
     */
    public  function getStatusArray()
    {
        return [
             self::NEWTASK => 'new',
             self::DONETASK => 'done',
             self::CANCELEDTASK => 'canceled',
        ];
    }
     /**
     * Get task priority array
     * @return array
     */
    public  function getPriorityArray()
    {
        return [
             self::IMPORTANTTASK => 'important',
             self::UNIMPORTANTTASK => 'unimportant',
        ];
    }
    /**
     * Get Status id Value
     * @param string $status
     * @return int
     */
    public function getStatusValue($status)
    {
        return array_search($status, $this->getStatusArray());
    }
    /**
     * Get Priority id value
     * @param string $priority
     * @return int
     */
    public function getPriorityValue($priority)
    {      
        return array_search($priority, $this->getPriorityArray());
    }
   /**
     * Get current photo
     * @param int $id 
     * @return array
     */
    public  function getCurrentFile($id)
    {        
        return Task::find()->select(['photo'])->where([ 'id' => $id ])->column();
    }
}
