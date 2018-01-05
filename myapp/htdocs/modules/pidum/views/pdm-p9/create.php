<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP9 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p9-create">

       <?= $this->render('_form', [
        'model' => $model,
		'modelPanggilanSaksi' => $modelPanggilanSaksi,
		'sysMenu'=> $sysMenu,
		'id'=>$id
    ]) ?>

</div>
