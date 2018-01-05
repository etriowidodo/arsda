<?php

use yii\helpers\Html;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmSysMenu;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT8 */


$this->title = "Rencana Dakwaan";
$this->subtitle = $sysMenu->keterangan;

?>
<div class="pdm-p29-update">

    <?= $this->render('_form', [
        'model' => $model,
		'id_berkas' => $id_berkas,
				 'modelJpu2' => $modelJpu2,
						  'modelJpu3' => $modelJpu3,
		'modelUu' => $modelUu,
        'modelSpdp' => $modelSpdp,
        'modelRp9' => $modelRp9,
        'modelPasal' => $modelPasal,
        'modelJPU' => $modelJPU,
        'modelAmarPutusan' => $modelAmarPutusan,
    ]) ?>

</div>
