<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPenyidik */

$this->title = 'Penyidik';
$this->subtitle ='Ms Penyidik';
?>
<div class="ms-penyidik-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
