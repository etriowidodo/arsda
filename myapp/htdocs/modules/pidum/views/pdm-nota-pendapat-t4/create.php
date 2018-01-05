<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmNotaPendapatT4 */

$this->title = 'Nota Pendapat T4';
//$this->params['breadcrumbs'][] = ['label' => 'Pdm Nota Pendapat T4s', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-nota-pendapat-t4-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model'     => $model,
        'modelJp16' => $modelJp16,
    ]) ?>

</div>