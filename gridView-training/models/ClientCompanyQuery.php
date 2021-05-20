<?php

namespace app\models;

/**
 * Gii
 * This is the ActiveQuery class for [[ClientCompany]].
 *
 * @see ClientCompany
 */
class ClientCompanyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ClientCompany[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ClientCompany|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
