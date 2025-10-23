<?php

namespace app\models;

use yii\base\Event;

/**
 * Custom event class for BOOK_ADDED event
 */
class BookAddedEvent extends Event
{
    /**
     * @var Book The book that was added
     */
    public $book;

    /**
     * @var array Author IDs for this book
     */
    public $authorIds = [];
}
