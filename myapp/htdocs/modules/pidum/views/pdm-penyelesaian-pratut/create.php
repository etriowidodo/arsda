<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratut */

$this->title = 'Create Pdm Penyelesaian Pratut';
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penyelesaian Pratuts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penyelesaian-pratut-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
