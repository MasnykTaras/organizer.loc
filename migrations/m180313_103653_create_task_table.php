<?php

use yii\db\Migration;

/**
 * Handles the creation of table `task`.
 */
class m180313_103653_create_task_table extends Migration
{
    public $table = 'task';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'user' => $this->string()->notNull()->defaultValue('None'),
            'priority' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->integer()->notNull()->defaultValue(0),
            'photo' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->table);
    }
}
