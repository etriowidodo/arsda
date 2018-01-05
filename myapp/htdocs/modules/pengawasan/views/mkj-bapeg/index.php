<?php

use kartik\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

//use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\MkjBapegSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'MKJ-BAPEG';
$this->subtitle = 'Majelis Kehormatan Jaksa - Badan Administrasi Kepegawaian';
$session = Yii::$app->session;
$this->params['ringkasan_perkara'] = $session->get('was_register');
/*$this->title = 'Mkj Bapegs';
$this->params['breadcrumbs'][] = $this->title;*/
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pengawasan/mkj-bapeg/delete'
        ]);
        ?>

            <div class="box box-primary" style="padding: 15px 0px;">
                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Rencana Penjatuhan Hukuman Disiplin</div>
                        <div class="panel-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="text-align: center">No.</th>
                                        <th rowspan="2" style="text-align: center">Nama - Pangkat - NIP/NRP - Jabatan</th>
                                        <th colspan="3" style="text-align: center">Saran</th>
                                    </tr>
                                    <tr>
                                        <th style="text-align: center">Tim Pemeriksa...</th>
                                        <th style="text-align: center">Inspektur...</th>
                                        <th style="text-align: center">Jaksa Agung Muda Pengawasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center">1</td>
                                        <td>Fulan <br/> Jaksa Pratama<br/> 19849357934574764/3435345<br/> Kasi Pidsus</td>
                                        <td>
                                            <select class="form-control">
                                                <option>- Pilih Saran -</option>
                                            </select>
                                            <div class="form-group">
                                                <label>Pasal</label>
                                                <input type="text" class="form-control" id="" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <select class="form-control">
                                                <option>- Pilih Saran -</option>
                                            </select>
                                            <div class="form-group">
                                                <label>Pasal</label>
                                                <input type="text" class="form-control" id="" readonly>
                                            </div>
                                        </td>
                                        <td>
                                            <select class="form-control">
                                                <option>- Pilih Saran -</option>
                                            </select>
                                            <div class="form-group">
                                                <label>Pasal</label>
                                                <input type="text" class="form-control" id="" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="padding-top: 15px;">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Keputusan MKJ/BAPEG</div>
                        <div class="panel-body">
                            <label class="radio-inline">
                                <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="yesCheck">Diubah
                            </label>
                            <label class="radio-inline">
                                <input type="radio" onclick="javascript:yesnoCheck();" name="yesno" id="noCheck" checked>Tetap
                            </label>
                            <table class="table table-bordered" id="ifYes" style="margin-top: 15px;display:none">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;width: 10px;">No.</th>
                                        <th style="text-align: center;width: 40px;">Nama - Pangkat - NIP/NRP - Jabatan</th>
                                        <th style="text-align: center">Keputusan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="text-align: center">1</td>
                                        <td>Fulan <br/> Jaksa Pratama<br/> 19849357934574764/3435345<br/> Kasi Pidsus</td>
                                        <td>
                                            <select class="form-control">
                                                <option>- Pilih Saran -</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12" style="padding-top: 15px;padding-bottom: 15px;">
                    <label>Unggah Berkas Keputusan MKJ/BAPEG</label>
                    <input type="file" />
                </div>
            </div>

    
        <?php ActiveForm::end() ?>
    </div>
</section>

<style type="text/css">
    .table-bordered>thead>tr>th{
        background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);
        border: 1px solid #81bcf8;
        color: #0f5e86;
    }
</style>
<script type="text/javascript">
    function yesnoCheck() {
        if (document.getElementById('yesCheck').checked) {
            document.getElementById('ifYes').style.display = 'inline-table';
        }
        else document.getElementById('ifYes').style.display = 'none';
    }
</script>
