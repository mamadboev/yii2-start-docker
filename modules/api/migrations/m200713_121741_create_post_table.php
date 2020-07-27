<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m200713_121741_create_post_table extends Migration
{
    public const TABLE_NAME= '{{%post}}';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'user_id'=> $this->integer(),
            'date' =>$this->timestamp(),
            'title'=>$this->string(),
            'text'=>$this->text(),
        ]);

        $this->createIndex(
            'idx-post-user_id',
            self::TABLE_NAME,
            'user_id'
        );
        $this->addForeignKey(
            'fk-post-user_id',
            self::TABLE_NAME,
            'user_id',
            '{{%user}}',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-post-user_id',self::TABLE_NAME);
        $this->dropIndex('idx-post-user_id',self::TABLE_NAME);
        $this->dropTable(self::TABLE_NAME);
    }
}
