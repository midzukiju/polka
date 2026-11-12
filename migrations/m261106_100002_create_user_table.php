<?php

use yii\db\Migration;

class m261106_100002_create_user_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'mail' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'auth_key' => $this->string(32),
            'role_id' => $this->integer()->notNull()->defaultValue(1),
            'year_goal' => $this->smallInteger(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);
        $this->addForeignKey('fk_user_role', '{{%user}}', 'role_id', '{{%role}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
