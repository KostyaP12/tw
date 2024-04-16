<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ip_locations}}`.
 */
class m240416_132919_create_ip_locations_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ip_locations', [
            'id' => $this->primaryKey(),
            'ip_address' => $this->string()->notNull(),
            'country' => $this->string(),
            'region' => $this->string(),
            'city' => $this->string(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('ip_locations');
    }
}
