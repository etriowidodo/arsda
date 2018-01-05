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
  function pilihTerlapor(id, param) {
    var value = $("#pilihTerlapor" + id).val();
    var data = value.split('#');
	//alert(data);
    var count = 1;
    $('#tbody_terlapor-' + param).append(
            '<tr id="terlapor-' + data[4] + '">' +
            '<td><input type="text" class="form-control" name="peg_nama[]" readonly="true" value="' + data[0] + '"> </td>' +
            '<td><input type="text" class="form-control" name="peg_nip_baru[]" readonly="true" value="' + data[1] + '"> </td>' +
            '<td><input type="text" class="form-control" name="jabatan[]" readonly="true" value="' + data[2] + '"> </td>' +
            '<td><button onclick="removeRow(\'terlapor-' + data[4] + '\')" class="btn btn-primary" type="button"><i class="fa fa-times"></i> Hapus</button></td>' +
            '</tr>'
            + '<input type="hidden" name="id_terlapor[]" value="' + data[3] + '" />'
            + '<input type="hidden" name="peg_nik_terlapor[]" value="' + data[4] + '" />'
            );
    $('#terlapor_was10').modal('hide');
  }
$(document).ready(function(){
    $("#add_chevron").click(function(){
        var nip=$(".checkbox-row:checked").val();
        var nama_terlapor = $(".checkbox-row:checked").attr('nama');
        var jabatan = $(".checkbox-row:checked").attr('jabatan');
       // alert(nip);
        // $('.bd_pemeriksa_tmp').append(
        //     '<tr><td></td><td>'+nip+'<input type=\"hidden\" name=\"nama_pemeriksa\" class=\"nama_pemeriksa\" value=\"'+nip+'\"></td>'+
        //     '<td>'+nama_pemeriksa+'<input type=\"hidden\" name=\"nama_pemeriksa\" class=\"nama_pemeriksa\" value=\"'+nama_pemeriksa+'\"></td>'+
        //     '<td>'+jabatan+'<input type=\"hidden\" name=\"nama_pemeriksa\" class=\"nama_pemeriksa\" value=\"'+jabatan+'\"></td><td></td><td></td></tr>');
    
        i = 0;
        $('.bd_terlapor_tmp').find('tr').each(function () {

        i++;
        $(this).addClass('terlapor'+i);
        // $(this).find('a').attr('rel', i)
        });
    });

    $("#simpan_terlapor").click(function(){
        var x=$(".checkbox-row:checked").length;
        var z;
		
        var checkValues = $('.checkbox-row:checked').map(function()
            {
                return $(this).val();
            }).get();
        //alert(checkValues);
        for (var i = 0; i < x; i++) {
         //alert(checkValues[i]);
            var tmp=checkValues[i].split('#');
            $(".terlapor_"+tmp[0]).remove();
            //alert(tmp[5]);
            // z='<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>'
        $('.bd_terlapor_tmp').append('<tr class=\"terlapor_'+tmp[0]+'\"><td></td><td>'+tmp[0]+'</td><td>'+tmp[1]+'</td><td>'+tmp[2]+'</td><td>'+tmp[5]+'</td><td style=\"text-align: center;\"><input type=\"checkbox\" name=\"ck_terlapor\" class=\"ck_terlapor\" value=\"'+tmp[0]+'\"></td>'+
            '<input type=\"hidden\" name=\"nip_terlapor[]\" class=\"nip_terlapor\" value=\"'+tmp[0]+'\">'+
            '<input type=\"hidden\" name=\"nama_terlapor[]\" class=\"nama_terlapor\" value=\"'+tmp[1]+'\">'+
            '<input type=\"hidden\" name=\"jabatan_terlapor[]\" class=\"jabatan_terlapor\" value=\"'+tmp[2]+'\">'+
            '<input type=\"hidden\" name=\"pangkat_terlapor[]\" class=\"pangkat_terlapor\" value=\"'+tmp[5]+'\">'+
            '<input type=\"hidden\" name=\"satker_terlapor[]\" class=\"satker_terlapor\" value=\"'+tmp[4]+'\">'+
            '<input type=\"hidden\" name=\"golongan_terlapor[]\" class=\"golongan_terlapor\" value=\"'+tmp[3]+'\"></tr>');
        };

       $("#terlapor_was10").modal('hide');
    });
});
</script>
<div class="col-sm-12">
<?php

$searchModel = new Was12Search();
        $dataProvider = $searchModel->searchTerlapor(Yii::$app->request->queryParams);
$dataProvider->pagination->pageSize = 5;
$gridColumn = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        //'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nip_pegawai_terlapor',
        'label' => 'NIP',
    ],
    [
        //'class' => '\kartik\grid\DataColumn',
        'attribute' => 'nama_pegawai_terlapor',
        'label' => 'Nama',
    ],
    [
       // 'class' => '\kartik\grid\DataColumn',
        'attribute' => 'jabatan_pegawai_terlapor',
        'label' => 'Jabatan',
    ],
    [
       // 'class' => '\kartik\grid\DataColumn',
        'attribute' => 'pangkat_pegawai_terlapor',
        'label' => 'Pangkat',
    ],
	[
       // 'class' => '\kartik\grid\DataColumn',
        'attribute' => 'satker_pegawai_terlapor',
        'label' => 'Satker',
    ],
    [
    'class' => 'yii\grid\CheckboxColumn',
       // 'checkboxOptions'=>['class'=>'checkbox-row','value'=>''],
    // you may configure additional properties here
       'checkboxOptions' => function ($data) {
        return ['value' => $data['nip_pegawai_terlapor'].'#'.$data['nama_pegawai_terlapor'].'#'.$data['jabatan_pegawai_terlapor'].'#'.$data['golongan_pegawai_terlapor'].'#'.$data['satker_pegawai_terlapor'].'#'.$data['pangkat_pegawai_terlapor'],'class'=>'checkbox-row'];
        
        },


    ],
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

<div class="col-sm-12">
<div class="box-footer" style="margin:0px;padding:0px;background:none;">
<a class="btn btn-primary btn-sm" id="simpan_terlapor">Simpan</a>
</div>
</div>