<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpahJaksa */

$this->title = 'Create Pdm Penyelesaian Pratut Limpah Jaksa';
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penyelesaian Pratut Limpah Jaksas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penyelesaian-pratut-limpah-jaksa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
