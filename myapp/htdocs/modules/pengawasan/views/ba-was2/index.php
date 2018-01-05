<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\pengawasan\models\pemeriksaBawas2;


$this->title = 'BA.WAS-2 Berita Acara Hasil Wawancara';
$this->params['breadcrumbs'][] = $this->title;
// $this->params['ringkasan_perkara'] = $_SESSION['was_register'];
?>
<?php// print_r($_SESSION); ?>
<div class="ba-was2-index">

    <div class="col-md-6" style="padding-left: 0px;margin-top: 10px;">
        <div class="form-group" style="padding-bottom: 30px;">
            <label class="control-label col-sm-4">Tanggal Berita Acara</label>
            <div class="col-sm-8">
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="text" id="" class="form-control" name="">
                    </div>
                </div>
            </div>                    
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Tempat</label>
            <div class="col-sm-8">
                <div class="form-group">
                    <div class="col-sm-12">
                        <textarea class="form-control"></textarea>
                    </div>
                </div>
            </div>                    
        </div>
    </div>

    <div class="col-md-6" style="padding-right: 0px;padding-bottom: 30px;">
        <fieldset class="scheduler-border">
            <legend class="scheduler-border"> SPRINT</legend>
            <div class="form-group row">
                <label for="inputKey" class="col-md-3 control-label">Nomor</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputKey" class="col-md-3 control-label">Tanggal</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="">
                </div>
            </div>
        </fieldset>
    </div>
</div>

<hr/>

<!-- tabel Daftar Pemeriksa -->
<div class="judul-tabel">
    <h4 class="pull-left" style="margin-left: 5px;"><strong>Daftar Pemeriksa</strong></h4>
</div>
<div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <div class="btn-toolbar">
        <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="glyphicon glyphicon-trash"> Hapus </i></a>
    </div>
    <div id="w0" class="grid-view">
        <div class="summary">Menampilkan <b>1-2</b> dari <b>2</b> item.</div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="">
                    <th style="width: 2%;text-align: center;">#</th>
                    <th style="width: 10%;">NIP</th>
                    <th style="width: 10%;">Nama</th>
                    <th style="width: 5%;">Jabatan </th>
                    <!-- <td style="text-align: center;width: 1%;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td> -->
                    <th style="width: 1%;text-align: center;"">Pilih</th>
                </tr>
            </thead>
            <tbody>
                <tr data-id="1" data-key="1" class="">
                    <td style="text-align: center;">1</td>
                    <td>198011192001011006</td>
                    <td>Dadang Darsono</td>
                    <td>Pemeriksa</td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
                <tr data-id="2" data-key="2" class="">
                    <td style="text-align: center;">2</td>
                    <td>198011192001011006</td>
                    <td>Dadang Darsono</td>
                    <td>Pemeriksa2</td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- tabel Daftar Pemeriksa -->

<!-- Daftar Saksi Yang Diwawancara (Saksi Internal) -->
<div class="judul-tabel">
    <h4 class="pull-left" style="margin-left: 5px;"><strong>Daftar Saksi Yang Diwawancara (Saksi Internal)</strong></h4>
</div>
<div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <div class="btn-toolbar">
        <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="glyphicon glyphicon-trash"> Hapus </i></a>
    </div>
    <div id="w0" class="grid-view">
        <div class="summary">Menampilkan <b>1-4</b> dari <b>4</b> item.</div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="">
                    <th style="width: 2%;text-align: center;">#</th>
                    <th style="width: 10%;">Nama</th>
                    <th style="width: 10%;">Pangkat</th>
                    <th style="width: 5%;">NIP/NRP</th>
                    <th style="width: 15%;">Jabatan</th>
                    <th style="width: 15%;">Satker</th>
                    <!-- <td style="text-align: center;width: 1%;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td> -->
                    <th style="width: 1%;text-align: center;"">Pilih</th>
                </tr>
            </thead>
            <tbody>
                <tr data-id="1" data-key="1" class="">
                    <td style="text-align: center;">1</td>
                    <td>Jajang Nurjaman</td>
                    <td>Yuana Wira TU</td>
                    <td>198911192010011002</td>
                    <td>Pengawal Tahanan</td>
                    <td>Kejari Sumedang</td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
                <tr data-id="1" data-key="1" class="">
                    <td style="text-align: center;">2</td>
                    <td>Jajang Turiman</td>
                    <td>Madya Wira TU</td>
                    <td>199010102009011006</td>
                    <td>Pengawal Keuangan</td>
                    <td>Kejari Sleman</td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
                <tr data-id="1" data-key="1" class="">
                    <td style="text-align: center;">3</td>
                    <td>Jajang Nur Wahid</td>
                    <td>Madya Wira TU</td>
                    <td>198611192010011002</td>
                    <td>Pengawal Tahanan</td>
                    <td>Kejari Ngawi</td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
                <tr data-id="1" data-key="1" class="">
                    <td style="text-align: center;">4</td>
                    <td>Jajang Nur Rokhim</td>
                    <td>Yuana Wira TU</td>
                    <td>199010102009011006</td>
                    <td>Caraka</td>
                    <td>Kejari Sumenep</td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Daftar Saksi Yang Diwawancara (Saksi Internal) -->

<!-- Daftar Saksi Yang Diwawancara (Saksi Eksternal) -->
<div class="judul-tabel">
    <h4 class="pull-left" style="margin-left: 5px;"><strong>Daftar Saksi Yang Diwawancara (Saksi Eksternal)</strong></h4>
</div>
<div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <div class="btn-toolbar">
        <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="glyphicon glyphicon-trash"> Hapus </i></a>
    </div>
    <div id="w0" class="grid-view">
        <div class="summary">Menampilkan <b>1-2</b> dari <b>10</b> item.</div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="">
                    <th style="width: 2%;text-align: center;">#</th>
                    <th style="width: 10%;">Nama</th>
                    <th style="width: 15%;">TTL</th>
                    <th style="width: 5%;">Kewarganegaraan</th>
                    <th style="width: 20%;">Alamat</th>
                    <th style="width: 5%;">Agama</th>
                    <th style="width: 5%;">Pekerjaan</th>
                    <!-- <td style="text-align: center;width: 1%;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td> -->
                    <th style="width: 1%;text-align: center;"">Pilih</th>
                </tr>
            </thead>
            <tbody>
                <tr data-id="1" data-key="1" class="">
                    <td style="text-align: center;">1</td>
                    <td>Jajang Nurjaman</td>
                    <td>Jakarta, 12 Desember 1986</td>
                    <td>Indonesia</td>
                    <td>Jalan Mawar No.1 Jakarta Selatan</td>
                    <td>Islam</td>
                    <td>Wiraswasta</td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
                <tr data-id="1" data-key="1" class="">
                    <td style="text-align: center;">2</td>
                    <td>Slamet</td>
                    <td>Solo, 12 Januari 1981</td>
                    <td>Indonesia</td>
                    <td>Jalan Melati No.1 Jakarta Selatan</td>
                    <td>Islam</td>
                    <td>Wiraswasta</td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Daftar Saksi Yang Diwawancara (Saksi Eksternal) -->

<!-- Hasil Wawancara -->
<div class="judul-tabel">
    <h4 class="pull-left" style="margin-left: 5px;"><strong>Hasil Wawancara</strong></h4>
</div>
<div class="box box-primary" style="padding: 15px;overflow: hidden;">
    <div class="btn-toolbar">
        <a class="btn btn-primary btn-sm pull-right" id="hapus_inspektur"><i class="glyphicon glyphicon-trash"> Hapus </i></a>
    </div>
    <div id="w0" class="grid-view">
        <div class="summary">Menampilkan <b>1-2</b> dari <b>10</b> item.</div>
        <table class="table table-striped table-bordered">
            <thead>
                <tr class="">
                    <th style="width: 1%;text-align: center;">#</th>
                    <th style="width: 10%;">Hasil Wawancara</th>
                    <!-- <td style="text-align: center;width: 1%;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td> -->
                    <th style="width: 1%;text-align: center;"">Pilih</th>
                </tr>
            </thead>
            <tbody>
                <tr data-id="1" data-key="1" class="">
                    <td style="text-align: center;">1</td>
                    <td>Jajang Nurjaman</td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
                <tr data-id="1" data-key="1" class="">
                    <td style="text-align: center;">2</td>
                    <td>Slamet</td>
                    <td style="text-align: center;"><input type="checkbox" class="checkbox-row" name="selection[]" value="1"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- Hasil Wawancara -->

<div class="col-md-6" style="padding-left: 0px;margin-top: 10px;">
    <div class="form-group" style="padding-bottom: 30px;">
        <label class="control-label col-sm-4">Penandatangan</label>
        <div class="col-sm-8">
            <div class="form-group">
                <div class="col-sm-12">
                    <select class="form-control">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                    </select>
                </div>
            </div>
        </div>                    
    </div>
</div>
<div class="clearfix"></div>

<div class="col-md-6" style="margin-top: 10px;">
    <div class="form-group" style="padding-bottom: 30px;">
        <label>Unggah Berkas WAS-12</label>
        <input type="file" />                   
    </div>
</div>


<style type="text/css">
    fieldset.scheduler-border {
        border: 1px solid #ddd;
        margin: 0;
        padding: 10px;
    }
    legend.scheduler-border {
        border-bottom: none;
        width: inherit;
        margin: 0;
        padding: 0px 5px;
        font-size: 14px;
        font-weight: bold;
    }
    .judul-tabel h4{
        border-bottom: 2px solid #73a8de;
    }
</style>