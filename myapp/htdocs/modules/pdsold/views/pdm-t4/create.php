<?php

use yii\helpers\Html;
use app\modules\pdsold\models\PdmSysMenu;
use app\components\GlobalConstMenuComponent;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT5 */

$sysMenu = PdmSysMenu::findAll(['kd_berkas' => GlobalConstMenuComponent::T4]);
$this->title = $sysMenu[0]->kd_berkas;
$this->subtitle = $sysMenu[0]->keterangan;
?>
<?php if (Yii::$app->session->getFlash('message') != null): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4>	<i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('message'); ?></h4>
    </div>
    <?php endif ?>
<div class="pdm-t4-create">
    <?=
    $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp,
        'modelTersangka' => $modelTersangka,
        'id' => $id,
        'modelPerpanjangan' => $modelPerpanjangan
    ])
    ?>

</div>
