<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Author $model */
?>

<div class="card shadow-sm">
    <div class="row g-0">
        <!-- Left: Author Name -->
        <div class="col-md-3">
            <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                <h4 class="text-center p-3 mb-0">
                    <?= Html::encode($model->name) ?>
                </h4>
            </div>
        </div>

        <!-- Right: Books List -->
        <div class="col-md-9">
            <div class="card-body">
                <h5 class="card-title">Books</h5>
                <?php if ($model->books): ?>
                    <ul class="list-unstyled mb-0">
                        <?php foreach ($model->books as $book): ?>
                            <li class="mb-2">
                                <a href="<?= Url::to(['book/view', 'id' => $book->id]) ?>">
                                    <?= Html::encode($book->title) ?>
                                </a>
                                <?php if ($book->year): ?>
                                    <span class="text-muted">(<?= Html::encode($book->year) ?>)</span>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p class="text-muted mb-0">No books yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
