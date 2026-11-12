<?php

use yii\db\Migration;

class m261106_100007_create_note_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%note}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
            'note' => $this->string(500)->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_note_user', '{{%note}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_note_book', '{{%note}}', 'book_id', '{{%book}}', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropTable('{{%note}}');
    }
}
