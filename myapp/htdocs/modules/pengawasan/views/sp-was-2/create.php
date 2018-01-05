<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SpWas2 */

$this->title = 'SP.WAS-2';
//$this->subtitle = 'Surat Perintah Melakukan Inspeksi Kasus';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');

$this->params['breadcrumbs'][] = ['label' => 'Sp Was2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sp-was2-create">

    <?= $this->render('_form', [
           'model' => $model,		
			'modelTerlapor' => $modelTerlapor,
			'modelPegawaiTerlapor' => $modelPegawaiTerlapor,
			'modelTembusanMaster' => $modelTembusanMaster,
			'modelWas2' => $modelWas2,
			'result_expire' => $result_expire,
	      
	]) ?>

</div>
