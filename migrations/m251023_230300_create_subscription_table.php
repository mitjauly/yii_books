<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%subscription}}`.
 */
class m251023_230300_create_subscription_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%subscription}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'phone' => $this->string(20)->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // Foreign key to author
        $this->addForeignKey(
            'fk-subscription-author',
            '{{%subscription}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE',  // Delete subscriptions when author is deleted
            'CASCADE'
        );

        // Index for searching subscriptions by author
        $this->createIndex('idx-subscription-author', '{{%subscription}}', 'author_id');

        // Index for searching by phone
        $this->createIndex('idx-subscription-phone', '{{%subscription}}', 'phone');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%subscription}}');
    }
}
