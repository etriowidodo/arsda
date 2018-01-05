<?php

use yii\helpers\Html;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmSysMenu;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA4 */
//$ket = app\modules\pidum\models\PdmSysMenu::findOne(['kd_berkas' => 'BA-15']);
$SysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::BA5]);
$this->title = $SysMenu->kd_berkas;
//print_r($ket);
//exit;
$this->subtitle = $SysMenu->keterangan;
//$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba4s', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_ba4, 'url' => ['view', 'id' => $model->id_ba4]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pdm-ba5-update">


    <?=
    $this->render('_form', [
        'model' => $model,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
        'modelTerdakwa' => $modelTerdakwa,
        'modeljaksi' => $modeljaksi,
        'id' => $id,
        'modelSpdp' => $modelSpdp,
        'modeljapen' => $modeljapen,
    ])
    ?>

</div>
