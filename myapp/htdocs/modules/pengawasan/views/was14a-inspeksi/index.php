<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\DasarSpWasMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-14A';
$this->params['breadcrumbs'][] = $this->title;
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
?>
<div class="dasar-sp-was-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <!--<?= Html::a('Tambah Dasar Sp Was Master', ['create'], ['class' => 'btn btn-success']) ?>-->
        <div class="btn-toolbar">
            <a class="btn btn-primary btn-sm pull-right" id="hapus_dasarspwas"><i class="fa fa-print"></i>&nbsp;&nbsp;Cetak </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="hapus_dasarspwas"><i class="glyphicon glyphicon-trash"></i>&nbsp;&nbsp;Hapus </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="ubah_dasarspwas"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Ubah </a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="create" href="/pengawasan/was14a-inspeksi/create"><i class="glyphicon glyphicon-plus"> </i>&nbsp;&nbsp;WAS-14A</a>
        </div>
    </p>

    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div id="w0" class="grid-view">
            <div class="summary">Menampilkan <b>1-2</b> dari <b>2</b> item.</div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="">
                        <th style="width: 2%;text-align: center;">#</th>
                        <th style="width: 10%;">No WAS-14 A</th>
                        <th style="width: 10%;">Nama Terlapor</th>
                        <th style="width: 5%;">Dari</th>
                        <th style="width: 15%;">Kepada</th>
                        <td style="text-align: center;width: 1%;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

