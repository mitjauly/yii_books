<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Author;

/** @var yii\web\View $this */
/** @var app\models\Book $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'authorIds')->dropDownList(
        ArrayHelper::map(Author::find()->orderBy('name')->all(), 'id', 'name'),
        ['multiple' => true, 'size' => 10]
    ) ?>

    <?= $form->field($model, 'photoFile')->fileInput() ?>

    <?php if ($model->photo): ?>
        <div class="form-group">
            <label>Current Photo</label><br>
            <img src="<?= Html::encode($model->photo) ?>" alt="Book Cover" style="max-width: 200px; max-height: 300px;">
        </div>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
