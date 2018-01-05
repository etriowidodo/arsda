<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SpWas2 */
$this->title = 'SP.WAS-2';
$this->subtitle = 'Surat Perintah Melakukan Inspeksi Kasus';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
$this->params['breadcrumbs'][] = ['label' => 'Sp Was2', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_sp_was2, 'url' => ['view', 'id' => $model->id_sp_was2]];
$this->params['breadcrumbs'][] = 'Update';

?>

<div class="sp-was2-update">

<?php 
	// print_r($model);
	// exit();
?>


    <?= $this->render('_form', [
        'model' => $model,
          'modelPemeriksa' => $modelPemeriksa,
          'modelTembusan'  => $modelTembusan,
          'modelDasarSurat' => $modelDasarSurat,
          'modelTerlapor'  => $modelTerlapor,
          'modelPegawaiTerlapor' => $modelPegawaiTerlapor,
         // 'modelWas2' => $modelWas2,
         // 'result_expire' => $result_expire,
		
    ]) ?>

</div>
