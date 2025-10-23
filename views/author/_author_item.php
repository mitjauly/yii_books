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
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Books</h5>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#subscribeModal-<?= $model->id ?>">
                        Subscribe
                    </button>
                </div>
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

<!-- Subscribe Modal -->
<div class="modal fade" id="subscribeModal-<?= $model->id ?>" tabindex="-1" aria-labelledby="subscribeModalLabel-<?= $model->id ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="<?= Url::to(['author/subscribe']) ?>">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                <?= Html::hiddenInput('author_id', $model->id) ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="subscribeModalLabel-<?= $model->id ?>">Subscribe to <?= Html::encode($model->name) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="phoneInput-<?= $model->id ?>" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone" id="phoneInput-<?= $model->id ?>" placeholder="Enter your phone number" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </div>
            </form>
        </div>
    </div>
</div>
