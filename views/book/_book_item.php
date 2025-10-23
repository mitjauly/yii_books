<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\Book $model */
?>

<div class="card shadow-sm">
    <div class="row g-0">
        <!-- Left: Book Cover -->
        <div class="col-md-3">
            <?php if ($model->photo): ?>
                <img src="<?= Html::encode($model->photo) ?>"
                     alt="<?= Html::encode($model->title) ?>"
                     class="img-fluid"
                     style="height: 250px; width: 100%; object-fit: cover;">
            <?php else: ?>
                <div class="bg-secondary text-white d-flex align-items-center justify-content-center"
                     style="height: 250px;">
                    <span style="font-size: 48px;">📖</span>
                </div>
            <?php endif; ?>
        </div>

        <!-- Right: Book Details -->
        <div class="col-md-9">
            <div class="card-body">
                <h5 class="card-title">
                    <a href="<?= Url::to(['view', 'id' => $model->id]) ?>">
                        <?= Html::encode($model->title) ?>
                    </a>
                </h5>

                <p class="mb-1"><strong>Year:</strong> <?= $model->year ?: 'N/A' ?></p>
                <p class="mb-1"><strong>ISBN:</strong> <?= $model->isbn ?: 'N/A' ?></p>
                <p class="mb-1">
                    <strong>Authors:</strong>
                    <?= $model->authors ? implode(', ', array_map(fn($a) => Html::encode($a->name), $model->authors)) : 'N/A' ?>
                </p>
                <?php if ($model->description): ?>
                    <p class="text-muted mb-0">
                        <?= mb_strlen($model->description) > 200 ? mb_substr(Html::encode($model->description), 0, 200) . '...' : Html::encode($model->description) ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
