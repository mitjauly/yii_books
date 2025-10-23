<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var array $topAuthors */

$this->title = 'Library';
?>
<div class="site-index">

    <h1>TOP 10 Authors by Year</h1>
    <p class="lead text-muted">Authors who published the most books each year</p>

    <?php if (empty($topAuthors)): ?>
        <div class="alert alert-info">
            No data available yet. Add some books and authors to see the report!
        </div>
    <?php else: ?>
        <?php foreach ($topAuthors as $year => $authors): ?>
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Year: <?= Html::encode($year) ?></h3>
                </div>
                <div class="card-body">
                    <ol class="mb-0">
                        <?php foreach ($authors as $author): ?>
                            <li class="mb-2">
                                <strong><?= Html::encode($author['author_name']) ?></strong>
                                <span class="badge bg-secondary"><?= $author['book_count'] ?> book<?= $author['book_count'] > 1 ? 's' : '' ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
