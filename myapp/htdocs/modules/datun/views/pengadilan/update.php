<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsInstPenyidik */

$this->title = 'Update Pengadilan' ;
/*
$this->params['breadcrumbs'][] = ['label' => 'Instansi Penyidik', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="ms-wilayah-provinsi-update">

    <?= $this->render('_form_add', [
        'model' => $model,
    ]) ?>

</div>
