<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_author}}`.
 */
class m251023_230200_create_book_author_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_author}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        // Composite primary key
        $this->addPrimaryKey('pk-book-author', '{{%book_author}}', ['book_id', 'author_id']);

        // Foreign keys
        $this->addForeignKey(
            'fk-book-author-book',
            '{{%book_author}}',
            'book_id',
            '{{%book}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-book-author-author',
            '{{%book_author}}',
            'author_id',
            '{{%author}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Indexes for performance
        $this->createIndex('idx-book-author-book', '{{%book_author}}', 'book_id');
        $this->createIndex('idx-book-author-author', '{{%book_author}}', 'author_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book_author}}');
    }
}
