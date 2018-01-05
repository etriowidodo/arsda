<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSurat */

$this->title = 'Create Nota Dinas';
//$this->params['breadcrumbs'][] = ['label' => 'Nota Dinas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-surat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    	'readOnly'=>$readOnly,
    	'modelJaksa'=>$modelJaksa,
    	'modelKpPegawai'=>$modelKpPegawai,
		'id'=>$id	
    ]) ?>

</div>
