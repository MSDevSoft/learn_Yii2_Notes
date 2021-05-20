<?php

use yii\db\Migration;

/**
 * Migracja przedstawiająca zakres danych
 *
 * Class m210520_180417_learn_grid_view
 */
class m210520_180417_learn_grid_view extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'user_name' => $this->string()->null(),
            'created_at' => $this->dateTime()
        ]);

        $this->createTable('client_company', [
            'id' => $this->primaryKey(),
            'company_name' => $this->string()->null(),
            'created_at' => $this->dateTime()
        ]);

        $this->createTable('person', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'client_company_id' => $this->integer(),
            'person_name' => $this->string()->null()
        ]);

        $this->addForeignKey('fk_person_client_company', 'person', 'client_company_id', 'client_company', 'id');
        $this->createIndex('inx_person_client_company_id', 'person', 'client_company_id');
        $this->addForeignKey('fk_person_user', 'person', 'user_id', 'user', 'id');
        $this->createIndex('inx_person_user_id', 'person', 'user_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_person_client_company', 'person');
        $this->dropForeignKey('fk_person_user', 'person');
        $this->dropIndex('inx_person_client_company_id', 'person');
        $this->dropIndex('inx_person_user_id', 'person');
        $this->dropTable('person');
        $this->dropTable('client_company');
        $this->dropTable('user');
    }
}
