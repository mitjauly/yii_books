<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Book $model */

$this->title = $model->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    <?php endif; ?>

    <div class="row">
        <!-- Left Column: Book Cover -->
        <div class="col-md-4">
            <?php if ($model->photo): ?>
                <img src="<?= Html::encode($model->photo) ?>" alt="<?= Html::encode($model->title) ?>"
                     class="img-fluid rounded shadow" style="width: 100%; max-width: 400px;">
            <?php else: ?>
                <div class="alert alert-secondary text-center" style="padding: 100px 20px;">
                    <i class="bi bi-book" style="font-size: 48px;"></i>
                    <p class="mt-2">No cover image</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right Column: Book Details -->
        <div class="col-md-8">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <th style="width: 150px;">Title:</th>
                        <td><?= Html::encode($model->title) ?></td>
                    </tr>
                    <?php if ($model->year): ?>
                    <tr>
                        <th>Year:</th>
                        <td><?= Html::encode($model->year) ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if ($model->isbn): ?>
                    <tr>
                        <th>ISBN:</th>
                        <td><?= Html::encode($model->isbn) ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Authors:</th>
                        <td>
                            <?php
                            $authors = $model->authors;
                            if ($authors) {
                                echo implode(', ', array_map(function($author) {
                                    return Html::encode($author->name);
                                }, $authors));
                            } else {
                                echo '<em class="text-muted">No authors specified</em>';
                            }
                            ?>
                        </td>
                    </tr>
                    <?php if ($model->description): ?>
                    <tr>
                        <th style="vertical-align: top;">Description:</th>
                        <td><?= nl2br(Html::encode($model->description)) ?></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
