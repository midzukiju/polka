<?php

use yii\db\Migration;

class m261106_100005_create_book_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'author' => $this->string()->notNull(),
            'genre_id' => $this->integer()->notNull(),
            'year_of_publication' => $this->smallInteger(),
            'number_of_pages' => $this->smallInteger(),
            'description' => $this->text(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_book_genre', '{{%book}}', 'genre_id', '{{%genre}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }
}
