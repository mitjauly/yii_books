<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subscription".
 *
 * @property int $id
 * @property int $author_id
 * @property string $phone
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Author $author
 */
class Subscription extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subscription';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'phone'], 'required'],
            [['author_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'match', 'pattern' => '/^[0-9\-\+\(\)\s]+$/', 'message' => 'Phone can only contain numbers, spaces, and symbols: + - ( )'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Author::class, 'targetAttribute' => ['author_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'phone' => 'Phone Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Author::class, ['id' => 'author_id']);
    }

    /**
     * Event handler for BOOK_ADDED event
     * Notifies all subscribers when their subscribed author publishes a new book
     *
     * @param BookAddedEvent $event
     */
    public static function onBookAdded($event)
    {
        \Yii::info("Event handler onBookAdded called", 'subscription');

        // Get data from custom event properties
        $book = $event->book;
        $authorIds = $event->authorIds;

        if (!$book || empty($authorIds)) {
            \Yii::info("Book or authorIds missing from event", 'subscription');
            return;
        }

        \Yii::info("Looking for subscriptions for authors: " . implode(', ', $authorIds), 'subscription');

        // Find all subscriptions for these authors
        $subscriptions = self::find()
            ->where(['author_id' => $authorIds])
            ->with('author') // Eager load authors to avoid N+1 queries
            ->all();

        \Yii::info("Found " . count($subscriptions) . " subscriptions", 'subscription');

        // Notify each subscriber
        foreach ($subscriptions as $subscription) {
            $subscription->notifyNewBook($book);
        }
    }

    /**
     * Send SMS notification about new book
     *
     * @param Book $book The new book that was added
     */
    public function notifyNewBook($book)
    {
        $message = "{$this->author->name} got new book {$book->title}, visit our library site.";
        $apiKey = \Yii::$app->params['smsApiKey'];

        // Build SMS API URL
        $url = 'https://smspilot.ru/api.php?' . http_build_query([
            'send' => $message,
            'to' => $this->phone,
            'apikey' => $apiKey,
        ]);

        \Yii::info("Sending SMS to {$this->phone}: {$message}", 'subscription');

        // Send SMS request
        $response = @file_get_contents($url);

        if ($response === false) {
            \Yii::info("SMS API request failed for {$this->phone}", 'subscription');
        } else {
            \Yii::info("SMS API response for {$this->phone}: {$response}", 'subscription');
        }
    }
}
