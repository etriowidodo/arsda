<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pengawasan\models\Was12Search;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script>
  function pilihPemeriksa(id, param) {
    var value = $("#pilihPemeriksa" + id).val();
    var data = value.split('#');
	
    var count = 1;
    $('#tbody_pemeriksa-' + param).append(
            '<tr id="pemeriksa-' + data[4] + '">' +
            '<td><input type="text" class="form-control" name="peg_nama[]" readonly="true" value="' + data[0] + '"> </td>' +
            '<td><input type="text" class="form-control" name="peg_nip_baru[]" readonly="true" value="' + data[1] + '"> </td>' +
            '<td><input type="text" class="form-control" name="jabatan[]" readonly="true" value="' + data[2] + '"> </td>' +
            '<td><button onclick="removeRow(\'pemeriksa-' + data[4] + '\')" class="btn btn-primary" type="button"><i class="fa fa-times"></i> Hapus</button></td>' +
            '</tr>'
            + '<input type="hidden" name="id_pemeriksa[]" value="' + data[3] + '" />'
            + '<input type="hidden" name="peg_nik_pemeriksa[]" value="' + data[4] + '" />'
            );
    $('#pemeriksa_was10').modal('hide');
  }
$(document).ready(function(){
    $("#add_chevron").click(function(){
        var nip=$(".checkbox-row:checked").val();
        var nama_pemeriksa = $(".checkbox-row:checked").attr('nama');
        var jabatan = $(".checkbox-row:checked").attr('jabatan');
        //alert(nip);
        // $('.bd_pemeriksa_tmp').append(
        //     '<tr><td></td><td>'+nip+'<input type=\"hidden\" name=\"nama_pemeriksa\" class=\"nama_pemeriksa\" value=\"'+nip+'\"></td>'+
        //     '<td>'+nama_pemeriksa+'<input type=\"hidden\" name=\"nama_pemeriksa\" class=\"nama_pemeriksa\" value=\"'+nama_pemeriksa+'\"></td>'+
        //     '<td>'+jabatan+'<input type=\"hidden\" name=\"nama_pemeriksa\" class=\"nama_pemeriksa\" value=\"'+jabatan+'\"></td><td></td><td></td></tr>');
    
        i = 0;
        $('.bd_pemeriksa_tmp').find('tr').each(function () {

        i++;
        $(this).addClass('terlapor'+i);
        // $(this).find('a').attr('rel', i)
        });
    });

    $("#simpan_pemeriksa").click(function(){
        var x=$(".checkbox1-row:checked").length;
        var z;
        // var nip=$(".checkbox-row:checked").val();
        // var nama_pemeriksa = $(".checkbox-row:checked").attr('nama');
        // var jabatan = $(".checkbox-row:checked").attr('jabatan');
        var checkValues1 = $('.checkbox1-row:checked').map(function()
            {
                return $(this).val();
            }).get();
        
        for (var i = 0; i < x; i++) {
        //alert(checkValues1[0]);
            var tmp=checkValues1[i].split('#');
	           $(".pemeriksa_"+tmp[0]).remove();
            // z='<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>'
        $('.bd_pemeriksa_tmp').append('<tr class=\"pemeriksa_'+tmp[0]+'\"><td></td><td>'+tmp[0]+'</td><td>'+tmp[1]+'</td><td>'+tmp[2]+'</td><td>'+tmp[3]+'</td><td style=\"text-align: center;\"><input type=\"checkbox\" name=\"ck_pemeriksa\" class=\"ck_pemeriksa\" value=\"'+tmp[0]+'\">'+
            '<input type=\"hidden\" name=\"nip[]\" class=\"nip\" value=\"'+tmp[0]+'\">'+
            '<input type=\"hidden\" name=\"nama_pemeriksa[]\" class=\"nama_pemeriksa\" value=\"'+tmp[1]+'\">'+
            '<input type=\"hidden\" name=\"jabatan[]\" class=\"jabatan\" value=\"'+tmp[2]+'\">'+
            '<input type=\"hidden\" name=\"pangkat[]\" class=\"pangkat\" value=\"'+tmp[3]+'\">'+
            '<input type=\"hidden\" name=\"golongan[]\" class=\"golongan\" value=\"'+tmp[4]+'\">'+
			'<input type=\"hidden\" name=\"nosurat[]\" class=\"nosurat\" value=\"'+tmp[5]+'\">'+
			'<input type=\"hidden\" name=\"terlapor[]\" class=\"terlapor\" value=\"'+tmp[6]+'\">'+
			'<input type=\"hidden\" name=\"hari[]\" class=\"hari\" value=\"'+tmp[7]+'\">'+
			'<input type=\"hidden\" name=\"tanggal[]\" class=\"tanggal\" value=\"'+tmp[8]+'\">'+
			'<input type=\"hidden\" name=\"jam[]\" class=\"jam\" value=\"'+tmp[9]+'\">'+
			'<input type=\"hidden\" name=\"tempat_pemeriksaan[]\" class=\"tempat_pemeriksaan\" value=\"'+tmp[10]+'\"></td></tr>');
			
        };

       $("#pemeriksa_was10").modal('hide');
    });
});
</script>
<div class="col-sm-12">
<?php


$searchModel = new Was12Search();
$dataProvider = $searchModel->searchPemeriksa(Yii::$app->request->queryParams);
$dataProvider->pagination->pageSize = 5;
$gridColumn = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        //'class' => '\kartik\grid\DataColumn',
        'attribute' => 'no_surat',
        'label' => 'No. Surat Was-10',
    ],
    // [
    //     //'class' => '\kartik\grid\DataColumn',
    //     'attribute' => 'nama_pegawai_terlapor',
    //     'label' => 'Nama Terlapor',
    // ],
    [
       // 'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nip_pemeriksa',
        'label' => 'NIP Pemeriksa',
    ],
    [
       // 'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nama_pemeriksa',
        'label' => 'Nama Pemeriksa',
    ],
	[
       // 'class' => '\kartik\grid\DataColumn',
        'attribute' => 'pangkat_pemeriksa',
        'label' => 'Pangkat Pemeriksa',
    ],[
       // 'class' => '\kartik\grid\DataColumn',
        'attribute' => 'jabatan_pemeriksa',
        'label' => 'Jabatan Pemeriksa',
    ],[
       // 'class' => '\kartik\grid\DataColumn',
        'attribute' => 'golongan_pemeriksa',
        'label' => 'Golongan Pemeriksa',
    ],
	
    [
    'class' => 'yii\grid\CheckboxColumn',
       // 'checkboxOptions'=>['class'=>'checkbox-row','value'=>''],
    // you may configure additional properties here
       'checkboxOptions' => function ($data) {
        return ['value' => $data['nip_pemeriksa'].'#'.$data['nama_pemeriksa'].'#'.$data['pangkat_pemeriksa'].'#'.$data['jabatan_pemeriksa'].'#'.$data['golongan_pemeriksa'].'#'.$data['no_surat'].'#'.$data['nama_pegawai_terlapor'].'#'.$data['hari_pemeriksaan_was10'].'#'.$data['tanggal_pemeriksaan_was10'].'#'.$data['jam_pemeriksaan_was10'].'#'.$data['tempat_pemeriksaan_was10'].'#'.$data['zona_waktu'].'#'.$data['no_surat'],'class'=>'checkbox1-row'];
        
        },


    ],
    // [
    //     'class' => '\kartik\grid\ActionColumn',
    //     'template' => '{pilih}',
    //     'buttons' => [
    //         'pilih' => function ($url, $model, $key) use($param) {
    //           return Html::button('<i class="fa fa-check"></i> Pilih', ['class' => 'btn btn-primary', 'onClick' => 'pilihPemeriksa(' . $model['id'] . ',"' . $param . '")',
    //                       'id' => 'pilihPemeriksa' . $model['id'],
    //                       'value' => $model['peg_nama'] . '#' .
    //                       $model['peg_nip_baru'] . '#' .
    //                       $model['jabatan'] . '#' .
    //                       $model['id'] . '#' .
    //                       $model['peg_nik']]);
    //         }
    //             ],
    //         ]
        ];
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'id' => 'gridPegawaiTT',
            'layout' => "{items}\n{pager}",
            'columns' => $gridColumn,
            'responsive' => true,
            'hover' => true,
            'export' => false,
            'pjax' => true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
            ],
            'pjaxSettings' => [
                'options' => [
                    'enablePushState' => false,
                ],
                'neverTimeout' => true,
            //  'beforeGrid'=>['columns'=>'peg_nip'],
            ]
        ]);
        ?>
</div>
<!-- <div class="col-sm-1">
<a class="btn btn-primary btn-sm" id="add_chevron"><i class="glyphicon glyphicon-chevron-right"></i></a>
<a class="btn btn-primary btn-sm" id="remove_chevron"><i class="glyphicon glyphicon-chevron-left"></i></a>
</div>

<div class="col-sm-5">
   <table class="kv-grid-table table table-hover table-bordered table-striped kv-table-wrap">
        <tr>
            <thead>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jabatan</th>
            </thead>
        </tr>
        <tbody class="bd_pemeriksa">
        </tbody>
   </table>
</div> -->

<div class="col-sm-12">
<div class="box-footer" style="margin:0px;padding:0px;background:none;">
<a class="btn btn-primary btn-sm" id="simpan_pemeriksa">Simpan</a>
</div>
</div>