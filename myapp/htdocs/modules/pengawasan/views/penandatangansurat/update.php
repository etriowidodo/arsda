<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Ubah Penandatangan Surat';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Penandatangan Surat', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nip, 'url' => ['view', 'id' => $model->nip]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="penandatangan-surat-master-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
<script type="text/javascript">
    $(document).ready(function(){
    	$("#kd_jbtn").hide();
    	$("#jbtn_pilih").hide();
    	$('#field_jbtn').attr('class','col-md-10');
    });

    </script>
    <?= $this->render('_form', [
        'model' => $model,
        'jbtn' => $jbtn,
        'nama_ttd' => $nama_ttd,
        'result_alias' => $result_alias,
    ]) ?>

    

</div>
