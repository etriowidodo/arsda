<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA3 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan
?>
<div class="pdm-ba3-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
				'model' => $model,
				'searchJPU' => $searchJPU,
				'dataJPU' => $dataJPU,
				'modeljaksi' => $modeljaksi, 
				'modelpenyidik' =>$modelpenyidik,
				'modelTersangka' => $modelTersangka,
				'modelSpdp' => $modelSpdp,
				'modelMsSaksi'=>$modelMsSaksi,
				'sysMenu' => $sysMenu,
				'id' => $id,
    ]) ?>

</div>
