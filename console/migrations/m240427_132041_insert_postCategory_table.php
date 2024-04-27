<?php

use yii\db\Migration;

/**
 * Class m240427_132041_insert_postCategori_table
 */
class m240427_132041_insert_postCategory_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('postCategory', ['name'], [
            ['nature'],
            ['food'],
            ['lifestyle'],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('postCategory', ['name' => ['nature', 'food', 'lifestyle']]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240427_132041_insert_postCategori_table cannot be reverted.\n";

        return false;
    }
    */
}
