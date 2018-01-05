<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsInstPenyidik */

$this->title = 'Update Wilayah Provinsi' ;
/*
$this->params['breadcrumbs'][] = ['label' => 'Instansi Penyidik', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';*/
?>
<div class="ms-wilayah-provinsi-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
