<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "note".
 *
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property string $note
 * @property string $created_at
 *
 * @property Book $book
 * @property User $user
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'note';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
{
    return [
        [['user_id', 'book_id', 'note'], 'required'],
        [['user_id', 'book_id'], 'integer'],
        [['created_at'], 'safe'],
        [['note'], 'string', 'max' => 500],
        [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
        [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
    ];
}

public function attributeLabels()
{
    return [
        'id' => 'ID',
        'user_id' => 'Пользователь',
        'book_id' => 'Книга',
        'note' => 'Заметка',
        'created_at' => 'Дата',
    ];
}

    /**
     * Gets query for [[Book]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
