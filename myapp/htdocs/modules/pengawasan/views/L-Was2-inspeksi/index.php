<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pengawasan\models\InspekturModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'L.WAS-2 Laporan Hasil Inspeksi Kasus';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dipa-master-index">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="panel with-nav-tabs panel-default">
        <div class="panel-heading single-project-nav">
            <ul class="nav nav-tabs"> 
                <li class="active">
                    <a href="#permasalahan" data-toggle="tab">Permasalahan</a>
                </li>
                <li>
                    <a href="#data" data-toggle="tab">Data</a>
                </li>
                <li>
                    <a href="#analisa" data-toggle="tab">Analisa</a>
                </li>
                <li>
                    <a href="#kesimpulan" data-toggle="tab">Kesimpulan</a>
                </li>
            </ul>
        </div>
        <div class="panel-body">
            <div class="tab-content">
                <div class="tab-pane fade in active" id="permasalahan">
                    <textarea name="editor1" id="editor1">Permasalahan</textarea>
                </div>
                <div class="tab-pane fade" id="data">
                    <textarea name="editor2" id="editor2">Data</textarea>
                </div>
                <div class="tab-pane fade" id="analisa">
                    <textarea name="editor3" id="editor3">Analisa</textarea>
                </div>
                <div class="tab-pane fade" id="kesimpulan">
                    <textarea name="editor4" id="editor4">Kesimpulan</textarea>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th rowspan="3" style="width: 1%;text-align: center;padding: 25px 10px;">#</th>
                <th rowspan="3" style="width: 20%;">Nama - Pangkat - NIP/NRP - Jabatan</th>
                <th colspan="3" style="text-align: center;">Pendapat</th>
            </tr>
            <tr>
                <th style="text-align: center;background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);color: #0f5e86;">Terbukti/Tidak Terbukti</th>
                <th style="text-align: center;background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);color: #0f5e86;">Bentuk Pelanggaran Disiplin</th>
                <th style="text-align: center;background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);color: #0f5e86;">Pasal</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Fulan - Jaksa Pratama - 19849357934574764/3435345 - Kasi Pidsus</td>
                <td>
                    <select class="form-control">
                        <option>- Pilih -</option>
                        <option>Terbukti</option>
                        <option>Tidak Terbukti</option>
                    </select>
                </td>
                <td>
                    <textarea class="form-control"></textarea>
                </td>
                <td>
                    <select class="form-control">
                        <option>- Pilih Pasal -</option>
                        <option>Terbukti</option>
                        <option>Tidak Terbukti</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="row" style="padding-top: 20px;">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Name-label">Hal- Hal Yang Memberatkan</label>
                    <textarea class="form-control" style="height: 100px;"></textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="Name-label">Hal- Hal Yang Meringankan</label>
                    <textarea class="form-control" style="height: 100px;"></textarea>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th rowspan="3" style="width: 1%;text-align: center;padding: 25px 10px;">#</th>
                <th rowspan="3" style="width: 20%;">Nama - Pangkat - NIP/NRP - Jabatan</th>
                <th colspan="3" style="text-align: center;">Saran</th>
            </tr>
            <!-- <tr>
                <th style="text-align: center;background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);color: #0f5e86;">Terbukti/Tidak Terbukti</th>
                <th style="text-align: center;background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);color: #0f5e86;">Bentuk Pelanggaran Disiplin</th>
                <th style="text-align: center;background-image: linear-gradient(to bottom, rgba(206, 230, 254, 1) 0%, rgba(178, 214, 250, 1) 100%);color: #0f5e86;">Pasal</th>
            </tr> -->
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Fulan - Jaksa Pratama - 19849357934574764/3435345 - Kasi Pidsus</td>
                <td>
                    <label>Saran</label>
                    <select class="form-control">
                        <option>- Pilih Saran-</option>
                        <option>Terbukti</option>
                        <option>Tidak Terbukti</option>
                    </select>
                </td>
                <td>
                    <label>Hukuman Disiplin</label>
                    <select class="form-control">
                        <option>- Pilih Hukuman Disiplin-</option>
                        <option> </option>
                    </select>
                </td>
                <td>
                    <label>Pasal</label>
                    <select class="form-control">
                        <option>- Pilih Pasal -</option>
                        <option>Terbukti</option>
                        <option>Tidak Terbukti</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="col-md-6" style="margin-top: 20px;">
        <div class="form-group" style="padding-bottom: 30px;">
            <label><strong>Unggah Berkas BA.WAS-3</strong></label>
            <input type="file" />                   
        </div>
    </div>

</div>

<script>
    CKEDITOR.replace( 'editor1' );
    CKEDITOR.replace( 'editor2' );
    CKEDITOR.replace( 'editor3' );
    CKEDITOR.replace( 'editor4' );
</script>

<style type="text/css">
    .panel-default > .panel-heading {
        background-color: #2a8cbd;
        color: #0f5e86;
        text-transform: uppercase;
        font-weight: 500;
    }
    .nav-tabs > li.active > a:after {
        position: absolute;
        content: " ";
        background: #2a8cbd;
        width: 12px;
        height: 12px;
        border-radius: 3px 0 0 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
        box-shadow: none;
        bottom: -40%;
        right: 50%;
    }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
        color: black;
        cursor: pointer;
        border: 1px solid transparent;
        border-radius: 0px;
        background-image: #fff;
    }
    .nav-tabs {
        border-bottom: 0px;
    }
    .nav-tabs>li>a{
        border-radius: 0px;
        color: #fff;
    }
</style>