<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPengembalian */

$this->title = $title;

?>
<div class="pdm-pengembalian-update">

    <?= $this->render('_form', [
        'model' => $model,
        'konstanta' => $konstanta,
        'modelPengembalian' => $modelPengembalian,
        'modelP21a'   => $modelP21a
    ]) ?>

</div>
