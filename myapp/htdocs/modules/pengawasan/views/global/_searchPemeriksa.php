<?php

use yii\helpers\Html;
use kartik\grid\GridView;

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
            '<tr id="trpemeriksa' + data[4] + '">' +
            '<td><input type="text" class="form-control" name="peg_nama[]" readonly="true" value="' + data[0] + '"> </td>' +
            '<td><input type="text" class="form-control" name="peg_nip_baru[]" readonly="true" value="' + data[1] + '"> </td>' +
            '<td><input type="text" class="form-control" name="jabatan[]" readonly="true" value="' + data[2] + '"> </td>' +
            '<td><button onclick="removeRow(\'pemeriksa-' + data[4] + '\')" class="btn btn-primary" type="button"><i class="fa fa-times"></i> Hapus</button></td>' +
            '</tr>'
            + '<input type="hidden" name="id_pemeriksa[]" value="' + data[3] + '" />'
            + '<input type="hidden" name="peg_nik_pemeriksa[]" value="' + data[4] + '" />'
            );
    $('#pemeriksa').modal('hide');
  }
function notify_double(style) {
    $.notify({
        title: 'Error Notification',
        text: 'Nip sudah Ada Harap Ganti Dengan yang lain'
        // image: "<img src='images/Mail.png'/>"
    }, {
        style: 'metro',
        className: style,
        autoHide: true,
        clickToHide: true
    });
}
$(document).ready(function(){
    $(".checkbox-row").change(function(){
        var data=$(this).val().split('#');
        // var nama_pemeriksa = $(".checkbox-row:checked").attr('nama');
        // var jabatan = $(".checkbox-row:checked").attr('jabatan');
        // alert(data[0]);
        // var x=$(".ck_pemeriksa"+data[0]).val();
        var z=$('.bd_pemeriksa_tmp').find(".trpemeriksa"+data[0]).attr('nilai');
        if(z==data[0]){
        // alert(x);
        // alert('Nip ini sudah ada');
        notify_double('black');
        $(this).prop('checked',false);
            
        }
        // $('.bd_pemeriksa_tmp').append(
        //     '<tr><td></td><td>'+nip+'<input type=\"hidden\" name=\"nama_pemeriksa\" class=\"nama_pemeriksa\" value=\"'+nip+'\"></td>'+
        //     '<td>'+nama_pemeriksa+'<input type=\"hidden\" name=\"nama_pemeriksa\" class=\"nama_pemeriksa\" value=\"'+nama_pemeriksa+'\"></td>'+
        //     '<td>'+jabatan+'<input type=\"hidden\" name=\"nama_pemeriksa\" class=\"nama_pemeriksa\" value=\"'+jabatan+'\"></td><td></td><td></td></tr>');
    
        // i = 0;
        // $('.bd_pemeriksa_tmp').find('tr').each(function () {

        // i++;
        // $(this).addClass('terlapor'+i);
        // // $(this).find('a').attr('rel', i)
        // });
    });
    


    $("#simpan_pemeriksa").click(function(){
        var x=$(".checkbox-row:checked").length;
        var z;
        // var nip=$(".checkbox-row:checked").val();
        // var nama_pemeriksa = $(".checkbox-row:checked").attr('nama');
        // var jabatan = $(".checkbox-row:checked").attr('jabatan');
        var checkValues = $('.checkbox-row:checked').map(function()
            {
                return $(this).val();
            }).get();
        
        for (var i = 0; i < x; i++) {
        // alert(checkValues[i]);
            var tmp=checkValues[i].split('#');
            // alert(tmp[0]);
            // z='<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>'
        $('.bd_pemeriksa_tmp').append('<tr class=\"trpemeriksa'+tmp[0]+'\" nilai=\"'+tmp[0]+'\"><td></td><td>'+tmp[0]+'</td><td>'+tmp[1]+'</td><td>'+tmp[2]+'</td><td>'+tmp[3]+'</td><td style=\"text-align: center;\"><input type=\"checkbox\" name=\"ck_pr_ubah\" class=\"td_riksa\" value=\"'+tmp[0]+'\"></td>'+
            '<input type=\"hidden\" name=\"nip[]\" class=\"nip\" value=\"'+tmp[0]+'\">'+
            '<input type=\"hidden\" name=\"nama_pemeriksa[]\" class=\"nama_pemeriksa\" value=\"'+tmp[1]+'\">'+
            '<input type=\"hidden\" name=\"jabatan[]\" class=\"jabatan\" value=\"'+tmp[2]+'\">'+
            '<input type=\"hidden\" name=\"pangkat[]\" class=\"pangkat\" value=\"'+tmp[3]+'\">'+
            '<input type=\"hidden\" name=\"nrp[]\" class=\"nrp\" value=\"'+tmp[4]+'\">'+
            '<input type=\"hidden\" name=\"golongan[]\" class=\"golongan\" value=\"'+tmp[5]+'\"></tr>');
        };
        $('.checkbox-row').prop('checked', false);
       $("#pemeriksa").modal('hide');
    });
});
</script>

<!-- <div class="col-sm-12"> -->
<?php
$kriteria = $kriteria;
// print_r(Yii::$app->request->queryParams);
// $searchModel = new \app\models\KpPegawaiSearch();
// $dataProvider = $searchModel->searchPegawai($kriteria);
// $dataProvider->pagination->pageSize = 5;
$gridColumn = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        //'class' => '\kartik\grid\DataColumn',
        'attribute' => 'peg_nip_baru',
        'label' => 'NIP',
    ],
    [
        //'class' => '\kartik\grid\DataColumn',
        'attribute' => 'peg_nama',
        'label' => 'Nama',
    ],
    [
       // 'class' => '\kartik\grid\DataColumn',
        'attribute' => 'jbtn_panjang',
        'label' => 'Jabatan',
    ],
    [
       // 'class' => '\kartik\grid\DataColumn',
        'attribute' => 'gol_pangkat',
        'label' => 'Pangkat',
    ],
    [
    'class' => 'yii\grid\CheckboxColumn',
       // 'checkboxOptions'=>['class'=>'checkbox-row','value'=>''],
    // you may configure additional properties here
       'checkboxOptions' => function ($data) {
        return ['value' => $data['peg_nip_baru'].'#'.$data['peg_nama'].'#'.$data['jbtn_panjang'].'#'.$data['gol_pangkat'].'#'.$data['peg_nrp'].'#'.$data['gol_jbt'].'#'.$data['peg_nip'],'class'=>'checkbox-row'];
        
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
            // 'filterModel' => $searchModel,
            'id' => 'gridPegawaiTT',
            // 'layout' => "{items}\n{pager}",
            'columns' => $gridColumn,
            'responsive' => true,
            'hover' => true,
            'export' => false,
            'pjax' => true,
            'panel' => [
                'type' => GridView::TYPE_PRIMARY,
                'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
            ],
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
<!-- </div> -->
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

