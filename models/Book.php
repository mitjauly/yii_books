<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title
 * @property int|null $year
 * @property string|null $description
 * @property string|null $isbn
 * @property string|null $photo
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Author[] $authors
 * @property BookAuthor[] $bookAuthors
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * Event triggered when a new book is added
     */
    const EVENT_BOOK_ADDED = 'bookAdded';

    /**
     * @var \yii\web\UploadedFile
     */
    public $photoFile;

    /**
     * @var array Author IDs for this book
     */
    public $authorIds = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'description', 'isbn', 'photo'], 'default', 'value' => null],
            [['title'], 'required'],
            [['year'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string'],
            [['title', 'photo'], 'string', 'max' => 255],
            [['isbn'], 'string', 'max' => 20],
            [['isbn'], 'unique'],
            [['photoFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024 * 1024 * 5], // 5MB max
            [['authorIds'], 'each', 'rule' => ['integer']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'year' => 'Year',
            'description' => 'Description',
            'isbn' => 'Isbn',
            'photo' => 'Photo',
            'photoFile' => 'Cover Photo',
            'authorIds' => 'Authors',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])->viaTable('book_author', ['book_id' => 'id']);
    }

    /**
     * Gets query for [[BookAuthors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthors()
    {
        return $this->hasMany(BookAuthor::class, ['book_id' => 'id']);
    }

    /**
     * Uploads the photo file.
     *
     * @return bool whether the upload was successful
     */
    public function upload()
    {
        if ($this->photoFile) {
            // Create directory if it doesn't exist
            $uploadPath = Yii::getAlias('@webroot/uploads/books');
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generate unique filename
            $filename = uniqid() . '.' . $this->photoFile->extension;
            $filePath = $uploadPath . '/' . $filename;

            // Save the file
            if ($this->photoFile->saveAs($filePath)) {
                // Delete old photo if exists
                if ($this->photo && file_exists(Yii::getAlias('@webroot') . $this->photo)) {
                    unlink(Yii::getAlias('@webroot') . $this->photo);
                }

                // Store relative path in database
                $this->photo = '/uploads/books/' . $filename;
                return true;
            }
        }
        return false;
    }

    /**
     * Load author IDs after finding the record
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->authorIds = $this->getAuthors()->select('id')->column();
    }

    /**
     * Save book-author relationships
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Delete existing relationships
        BookAuthor::deleteAll(['book_id' => $this->id]);

        // Create new relationships
        if (!empty($this->authorIds)) {
            foreach ($this->authorIds as $authorId) {
                $bookAuthor = new BookAuthor();
                $bookAuthor->book_id = $this->id;
                $bookAuthor->author_id = $authorId;
                $bookAuthor->save();
            }
        }

        // Trigger BOOK_ADDED event for new books only
        if ($insert && !empty($this->authorIds)) {
            \Yii::info("Triggering BOOK_ADDED event for book '{$this->title}' with authors: " . implode(', ', $this->authorIds), 'subscription');

            $event = new BookAddedEvent();
            $event->book = $this;
            $event->authorIds = $this->authorIds;
            $this->trigger(self::EVENT_BOOK_ADDED, $event);
        }
    }

}
