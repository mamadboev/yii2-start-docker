<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m200527_080434_create_user_table extends Migration
{
    public const TABLE_NAME = '{{%user}}';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id'         => $this->primaryKey(),
            'username'   => $this->string(),
            'password_hash'=>$this->string(),
            'auth_token'=>$this->string(),
        ]);
        $this->createIndex(
            'idx-user-username',
            self::TABLE_NAME,
            'username'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-user-username',self::TABLE_NAME);

        $this->dropTable(self::TABLE_NAME);
    }
}
