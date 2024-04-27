<?php

use yii\db\Migration;

/**
 * Class m240427_140327_add_ForeignKey_postCategoriId_in_Post_table
 */
class m240427_140327_add_ForeignKey_postCategoriId_in_Post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey(
            'post_category_id',
            'Post',
            'post_category_id',
            'postCategory',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('post_category_id', 'Post');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240427_140327_add_ForeignKey_postCategoriId_in_Post_table cannot be reverted.\n";

        return false;
    }
    */
}
