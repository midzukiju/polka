<?php

use yii\db\Migration;

class m261106_100004_create_status_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%status}}', [
            'id' => $this->primaryKey(),
            'status' => $this->string()->notNull()->unique(),
        ]);
        $this->batchInsert('{{%status}}', ['id', 'status'], [
            [1, 'В планах'],
            [2, 'Прочитано'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%status}}');
    }
}
