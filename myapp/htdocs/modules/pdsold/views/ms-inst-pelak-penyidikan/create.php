<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsInstPelakPenyidikan */


$this->title = 'Instansi Pelaksana Penyidikan';
/*
$this->params['breadcrumbs'][] = ['label' => 'Instansi Pelaksana Penyidikan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="ms-inst-pelak-penyidikan-create">

    <?= $this->render('_form', [
        'model' 	=> $model,
        'kode'     => $kode,
    ]) ?>

</div>
