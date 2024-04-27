<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%postCategory}}`.
 */
class m240427_131139_create_postCategory_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%postCategory}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%postCategory}}');
    }
}
