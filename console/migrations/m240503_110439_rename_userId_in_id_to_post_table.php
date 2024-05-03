<?php

use yii\db\Migration;

/**
 * Class m240503_110439_add_id_column_and_conn_userId_to_post_table
 */
class m240503_110439_rename_userId_in_id_to_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('Post', 'user_id', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('Post', 'id', 'user_id');

        return false;
    }

}
