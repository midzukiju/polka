<?php

use yii\db\Migration;

class m261106_100003_create_genre_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%genre}}', [
            'id' => $this->primaryKey(),
            'genre' => $this->string()->notNull()->unique(),
        ]);
        $this->batchInsert('{{%genre}}', ['genre'], [
            ['Классика'],
            ['Фантастика'],
            ['Детектив'],
            ['Наука'],
            ['Фэнтези'],
            ['Поэзия'],
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%genre}}');
    }
}
