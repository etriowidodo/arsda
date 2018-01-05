<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'WAS-10 Surat Permintaan Keterangan Terlapor';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dipa-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <div class="btn-toolbar">
            <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="glyphicon glyphicon-trash"> Hapus </i></a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right" id="ubah_inspektur"><i class="glyphicon glyphicon-pencil"> Ubah </i></a>&nbsp;
            <a class="btn btn-primary btn-sm pull-right"  data-toggle="modal" data-target="#create"><i class="glyphicon glyphicon-plus"> Terlapor</i></a>
            <!-- <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was-10-inspeksi/form1"><i class="glyphicon glyphicon-plus"> Terlapor</i></a> -->
        </div>
    </p>

    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div id="w0" class="grid-view">
            <div class="summary">Menampilkan <b>1-2</b> dari <b>2</b> item.</div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="">
                        <th style="width: 2%;text-align: center;">#</th>
                        <th style="width: 10%;">NIP / NRP</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 5%;">Golongan</th>
                        <th style="width: 4%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-id="1" data-key="1" class="">
                        <td style="text-align: center;">1</td>
                        <td>102938538493847323</td>
                        <td>Eka Julian B</td>
                        <td>IV.A</td>
                        <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1">
                    </tr>
                    <tr data-id="2" data-key="2" class="">
                        <td style="text-align: center;">2</td>
                        <td>102938538493847323</td>
                        <td>Eka Julian B</td>
                        <td>IV.A</td>
                        <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1">
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <p>
        <div class="btn-toolbar">
            <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was-10-inspeksi/index"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;&nbsp;Simpan</a>
            <a class="btn btn-primary btn-sm pull-right" href="/pengawasan/was-10-inspeksi/index"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;&nbsp;Batal</a>
        </div>
    </p>

    <!-- Modal Tambah Baru -->
    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Tambah Terlapor</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
                        <div id="w0" class="grid-view">
                            <div class="summary">Menampilkan <b>1-2</b> dari <b>2</b> item.</div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="">
                                        <th style="width: 2%;text-align: center;">#</th>
                                        <th style="width: 10%;">NIP / NRP</th>
                                        <th style="width: 20%;">Nama</th>
                                        <th style="width: 5%;">Golongan</th>
                                        <th style="width: 4%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-id="1" data-key="1" class="">
                                        <td style="text-align: center;">1</td>
                                        <td>102938538493847323</td>
                                        <td>Eka Julian B</td>
                                        <td>IV.A</td>
                                        <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                                    </tr>
                                    <tr data-id="2" data-key="2" class="">
                                        <td style="text-align: center;">2</td>
                                        <td>102938538493847323</td>
                                        <td>Eka Julian B</td>
                                        <td>IV.A</td>
                                        <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tambah</button>
                </div>
            </div>
        </div>
    </div>