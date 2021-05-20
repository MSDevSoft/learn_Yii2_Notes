<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "client_company".
 *
 * @property int $id
 * @property string|null $company_name
 * @property string|null $created_at
 *
 * @property Person[] $people
 * @property Person $person
 * @property User $user
 */
class ClientCompany extends \yii\db\ActiveRecord
{
    /**
     * ###!!!
     * Dodatkowe wymagane pole dla filtrowania danych na liście client company
     */
    public $person_id;

    /**
     * ###!!!
     * Dodatkowe wymagabe pole dla filtrowania danych na liście client company
     */
    public $user_name;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client_company';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['company_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_name' => 'Company Name',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[People]].
     *
     * @return \yii\db\ActiveQuery|PersonQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['client_company_id' => 'id']);
    }

    /**
     * ###!!!
     * Wymagana relacja One2One żeby zadziałało filtrowanie na liście
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::class, ['client_company_id' => 'id']);
    }

    /**
     * ###!!!
     * Wymagana relacja One2One żeby zadziałało filtrowanie na liście
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])
            ->via('person');
    }

    /**
     * {@inheritdoc}
     * @return ClientCompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientCompanyQuery(get_called_class());
    }
}
