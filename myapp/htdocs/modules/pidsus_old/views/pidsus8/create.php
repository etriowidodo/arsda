<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSurat */

$this->title = 'Create Surat Pidsus-8';
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus', 'url' => ['../pidsus/default/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Pidsus8', 'url' => ['../pidsus/pidsus8/index?id='.$id]];
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
