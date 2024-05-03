<?php

use yii\db\Migration;

/**
 * Class m240503_113902_add_FK_userId_to_post_table_for_conn_user_table
 */
class m240503_113902_add_FK_userId_to_post_table_for_conn_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('Post', 'user_id', 'integer');
        $this->addForeignKey(
            'fk_user_id_post',
            'Post',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk_user_id_post',
            'Post'
        );
        $this->dropColumn('post', 'user_id');

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240503_113902_add_FK_userId_to_post_table_for_conn_user_table cannot be reverted.\n";

        return false;
    }
    */
}
