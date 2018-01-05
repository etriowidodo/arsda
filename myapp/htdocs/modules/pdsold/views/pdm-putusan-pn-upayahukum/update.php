<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP41 */

$this->title = 'Putusan Pengadilan';
//$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-putusan-pn-update">

    <?= //echo '<pre>';print_r($pasal);exit;
        $this->render('_form', [
        'model'                 => $model,
        'model_pn'              => $model_pn,
        'modelSpdp'             => $modelSpdp,
        'statp41'               => $statp41,
        'tersangka'             => $tersangka,
        'modelBarbuk'           => $modelBarbuk,

        'modelTerdakwa'         => $modelTerdakwa,
        'pasal'                 => $pasal,
        'no_register_perkara'   => $no_register_perkara,
        'searchModelBerkas'     => $searchModelBerkas,
        'dataProviderBerkas'    => $dataProviderBerkas,
        'rp11'                  => $rp11,
        'no_akta' => $no_akta,
    ]) ?>

</div>
