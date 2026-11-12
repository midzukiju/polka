<?php

use yii\db\Migration;

class m261106_100006_create_user_book_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user_book}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
            'status_id' => $this->integer()->notNull()->defaultValue(1),
            'rating' => $this->tinyInteger(),
            'is_favorite' => $this->boolean()->notNull()->defaultValue(0),
            'read_at' => $this->date(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->createIndex('uq_user_book', '{{%user_book}}', ['user_id', 'book_id'], true);
        $this->addForeignKey('fk_ub_user', '{{%user_book}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_ub_book', '{{%user_book}}', 'book_id', '{{%book}}', 'id', 'CASCADE');
        $this->addForeignKey('fk_ub_status', '{{%user_book}}', 'status_id', '{{%status}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%user_book}}');
    }
}
