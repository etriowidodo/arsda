<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\pdmt7 */

$this->title = 'T-7';
$this->subtitle = 'Surat perintah Penahanan/Pengalihan jenis Penahanan';
?>
<div class="pdmt7-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelJpu' => $modelJpu,
		 'modelnotaPendapat' => $modelnotaPendapat,
		'modelSpdp' => $modelSpdp,
		'searchJPU' => $searchJPU,
        'modelTindakanStatus'=>$modelTindakanStatus,
		'dataProviderJPU' => $dataProviderJPU,
		'sysMenu' => $sysMenu
    ]) ?>

</div>
