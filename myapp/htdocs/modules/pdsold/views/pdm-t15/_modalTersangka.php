<?php
/**
 * Created by PhpStorm.
 * User: citraprana
 * Date: 8/18/15
 * Time: 2:44 PM
 */

?>

<script>

    function pilihTersangka(id_tersangka, nm_tersangka, almt_tersangka, pekerjaan_tersangka, pendidikan_tersangka){
        $('#tbody_tersangka').append(
            '<tr id="row">' +
                '<td><input type="hidden" class="form-control" id="pdmt15-id_tersangka" name="PdmT15[id_tersangka]" readonly="true" value="'+id_tersangka+'">' +
                '<input type="text" class="form-control" name="nmTersangka" readonly="true" value="'+nm_tersangka+'"></td>' +
                '<td><input type="text" class="form-control" name="almtTersangka" readonly="true" value="'+almt_tersangka+'"></td>' +
                '<td><input type="text" class="form-control" name="pekerjaanTersangka" readonly="true" value="'+pekerjaan_tersangka+'"></td>' +
                '<td><input type="text" class="form-control" name="pendidikanTersangka" readonly="true" value="'+pendidikan_tersangka+'"></td>' +
                //'<td><a class="btn btn-primary" id="btn_hapus_tersangka">Hapus</a></td>' +
                '<td><input type="button" class="btn btn-danger delete hapus" name="btnHapus" value="" onclick="delRow()"></td>' +
            '</tr>'
            /*'<tr id="trterlapor'+nip+'">' +
                '<td><input type="text" class="form-control" name="namaTerlapor[]" readonly="true" value="'+nama+'"> </td>' +
                '<td><input type="text" class="form-control" name="nipTerlapor[]" readonly="true" value="'+nip+'">'+
                '<input type="hidden" class="form-control" name="idPegawai[]" readonly="true" value="'+id+'">'+
                '<input type="hidden" class="form-control" name="peg_nik[]" readonly="true" value="'+peg_nik+'">'+
                '</td>' +
                '<td><input type="text" class="form-control" name="jabatanTerlapor[]" readonly="true" value="'+jabatan+'"> </td>' +
                '<td><a class="btn btn-primary" id="btn_delete_tersangka">Hapus</a></td>'+
                '</tr>'*/
        );
        $("#btnTmbhTersangka").hide();

        $.ajax({
            url: '<?= Yii::$app->request->baseUrl. '/pdsold/pdm-t15/get-ciri-khusus' ?>',
            type: 'post',
            dataType: 'json',
            data: {idTersangka: id_tersangka},
            success: function(data) {
                //console.log(data.tersangka.warganegara);
                $("#mstersangka-tinggi").val(data.tersangka.tinggi);
                $("#mstersangka-kulit").val(data.tersangka.kulit);
                $("#mstersangka-muka").val(data.tersangka.muka);
                $("#mstersangka-ciri_khusus").val(data.tersangka.ciri_khusus);
            }
        });

        $('#m_tersangka').modal('hide');
    }
</script>


<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="modalContent">

    <?= GridView::widget([
        'id'=>'gridTersangka',
        'dataProvider'=> $dataProviderTersangka,
        //'filterModel' => $searchPegawai,
        'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'Nama',
                'attribute' => 'nama',
            ],
            [
                'label'=>'Alamat',
                'attribute' => 'alamat',
            ],
            [
                'label'=>'Pendidikan',
                'attribute' => 'is_pendidikan',
            ],
            [
                'label'=>'Pekerjaan',
                'attribute' => 'pekerjaan',
            ],

            /*
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{select}',
                'buttons' => [
                    'select' => function ($url, $model) {
                        return Html::checkbox('pilih', false, ['value' => $model['peg_nip'].'#'.$model['peg_nama'].'#'.$model['peg_tmplahirkab'].'#'.$model['peg_tgllahir']]);
                    },
                ]
            ],
            */

            [
                'class' => '\kartik\grid\ActionColumn',
                'template' => '{pilih}',
                'buttons' => [
                    'pilih' => function ($url, $model,$key) {
                            return Html::button("Pilih", ["id"=>"btnPilihTersangka", "class"=>"btn btn-success",
                                "id_tersangka"=>$model['id_tersangka'],
                                "nm_tersangka"=>$model['nama'],
                                "almt_tersangka"=>$model['alamat'],
                                "pendidikan_tersangka"=>$model['is_pendidikan'],
                                "pekerjaan_tersangka"=>$model['pekerjaan'],
                                "onClick"=>"pilihTersangka($(this).attr('id_tersangka'), $(this).attr('nm_tersangka'), $(this).attr('almt_tersangka'),$(this).attr('pendidikan_tersangka'),$(this).attr('pekerjaan_tersangka'))"]);
                        }
                ],
            ]

        ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
        ],

        /*
        'pjaxSettings'=>[
            'options'=>[
                'enablePushState'=>false,
            ],
            'neverTimeout'=>true,
            'afterGrid'=>'<a id="pilih-terlapor" class="btn btn-success">Pilih</a>',
        ]
        */

    ]); ?>

</div>