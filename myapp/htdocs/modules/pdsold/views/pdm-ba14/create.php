<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA14 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba14-create">


    <?= $this->render('_form', [
        'model' => $model,
        'modelTersangka' => $modelTersangka,
        'modelSpdp' => $modelSpdp,
        'modeljaksi' => $modeljaksi, 
        'sysMenu' => $sysMenu,
        'modelRp9' =>$modelRp9
    ]) ?>

</div>
