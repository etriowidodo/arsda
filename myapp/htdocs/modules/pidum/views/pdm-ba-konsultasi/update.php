<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBaKonsultasi */

//$this->title = 'Update Pdm Ba Konsultasi: ' . ' ' . $model->id_perkara;
//$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba Konsultasis', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_perkara, 'url' => ['view', 'id_perkara' => $model->id_perkara, 'id_ba_konsultasi' => $model->id_ba_konsultasi]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-ba-konsultasi-update">


    <?= $this->render('_form', [
        'model' => $model,
        'jaksa' => $jaksa,
        'jaksa_p16' => $jaksa_p16,
    ]) ?>

</div>
