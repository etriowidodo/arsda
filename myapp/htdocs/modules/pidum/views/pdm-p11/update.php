<?php

use yii\helpers\Html;
use app\modules\pidum\models\PdmSysMenu;
use app\components\GlobalConstMenuComponent;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT5 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p11-update">

    <?= $this->render('_form', [
        'model' => $model,
        // 'modelSpdp' => $modelSpdp,
        'modelTersangka' => $modelTersangka
        
    ]) ?>

</div>
