<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_book".
 *
 * @property int $id
 * @property int $user_id
 * @property int $book_id
 * @property int $status_id
 * @property int|null $rating
 * @property int $is_favorite
 * @property string|null $read_at
 * @property string $created_at
 *
 * @property Book $book
 * @property Status $status
 * @property User $user
 */
class UserBook extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
{
    return [
        [['user_id', 'book_id'], 'required'],
        [['user_id', 'book_id', 'status_id'], 'integer'],
        [['rating'], 'integer', 'min' => 1, 'max' => 5],
        [['is_favorite'], 'boolean'],
        [['read_at', 'created_at'], 'safe'],
        [['user_id', 'book_id'], 'unique', 'targetAttribute' => ['user_id', 'book_id'], 'message' => 'Эта книга уже есть на полке'],
        [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Book::className(), 'targetAttribute' => ['book_id' => 'id']],
        [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::className(), 'targetAttribute' => ['status_id' => 'id']],
        [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
    ];
}

public function attributeLabels()
{
    return [
        'id' => 'ID',
        'user_id' => 'Пользователь',
        'book_id' => 'Книга',
        'status_id' => 'Статус',
        'rating' => 'Оценка',
        'is_favorite' => 'Избранное',
        'read_at' => 'Прочитана',
        'created_at' => 'Добавлена',
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
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
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
