<?php

use yii\db\Migration;
use yii\base\Security;

/**
 * Handles the creation of table `user`.
 */
class m180315_140828_create_user_table extends Migration
{
    public $table = 'user';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),           
        ]);
        
        $this->batchInsert($this->table, ['id', 'username', 'auth_key', 'password_hash' ], [
            ['1', 'webmaster', $this->generateAuthKey(), $this->generatePassHash('webmaster')], 
            ['2', 'User 1', $this->generateAuthKey(), $this->generatePassHash('user1')], 
            ['3', 'User 2', $this->generateAuthKey(), $this->generatePassHash('user2')],
            ['4', 'User 3', $this->generateAuthKey(), $this->generatePassHash('user3')],
            ['5', 'User 4', $this->generateAuthKey(), $this->generatePassHash('user4')],
        ]);
     
        $this->addForeignKey('user_id', 'task', 'user_id', 'user', 'id');
        $this->createIndex('user_id', 'task', 'user_id');
    }
    private function generatePassHash($pass)
    {          
        return Yii::$app->security->generatePasswordHash($pass);          
    }
    private function generateAuthKey()
    {
        return Yii::$app->security->generateRandomString();          
    }
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
      
        $this->dropForeignKey('user_id', 'task');
        $this->dropIndex('user_id', 'task');
    }
}
