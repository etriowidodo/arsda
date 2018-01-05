<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmNotaPendapatT4 */

$this->title = 'Nota Pendapat T4';
//$this->params['breadcrumbs'][] = ['label' => 'Pdm Nota Pendapat T4s', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_perpanjangan, 'url' => ['view', 'id_perpanjangan' => $model->id_perpanjangan, 'id_nota_pendapat' => $model->id_nota_pendapat]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-nota-pendapat-t4-update">


    <?= $this->render('_form', [
        'model'     => $model,
        'modelJp16' => $modelJp16,
    ]) ?>

</div>