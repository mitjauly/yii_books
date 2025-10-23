<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AuthorSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="author-search mb-3">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="input-group">
        <?= Html::activeTextInput($model, 'name', [
            'class' => 'form-control',
            'placeholder' => 'Search authors...'
        ]) ?>
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Clear', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
