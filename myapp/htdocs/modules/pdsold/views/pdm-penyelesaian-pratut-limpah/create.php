<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpah */

$this->title = 'Create Pdm Penyelesaian Pratut Limpah';
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penyelesaian Pratut Limpahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penyelesaian-pratut-limpah-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
