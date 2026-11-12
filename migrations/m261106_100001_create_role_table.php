<?php

use yii\db\Migration;

class m261106_100001_create_role_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%role}}', [
            'id' => $this->primaryKey(),
            'role' => $this->string(50)->notNull()->unique(),
        ]);
        $this->batchInsert('{{%role}}', ['id', 'role'], [
            [1, 'user'],
            [2, 'admin'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%role}}');
    }
}
