<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%Post}}`.
 */
class m240427_132923_create_Post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Post}}', [
            'user_id' => $this->primaryKey(),
            'title' => $this->string(),
            'text' => $this->text(),
            'post_category_id' => $this->integer()->notNull(),
            'status' => $this->integer(),
            'image'=> $this->string(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%Post}}');
    }
}
