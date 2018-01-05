<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pidum\models\PdmJaksaP16a;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use app\modules\pidum\models\PdmP16a;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP16ASearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p16a-index">
    <div id="divTambah" class="col-md-11" style="width:80%;">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
<!--    <div  class="col-md-1" style="width:5%;">
        <button id="cetak" class='btn btn-primary btnPrintCheckboxIndex' disabled>Cetak</button>
    </div>-->
    <div  class="col-md-1" style="width:5%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pidum/pdm-p16a/delete'
    ]);
    ?>
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_surat_p16a']];
            },
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute'=>'no_surat_p16a',
                            'label' => 'Nomor / Tanggal Surat Perintah',
                            'format' => 'raw',
                            'value'=>function ($model, $key, $index, $widget) {
                                return $model->no_surat_p16a."<br/>".date("d-m-Y", strtotime($model->tgl_dikeluarkan));
                            },
                        ],
                                    
                        [
                            'attribute'=>'jaksa',
                            'label' => 'Jaksa Penuntut Umum',
                            'format' => 'raw',
                            'value'=>function ($model, $key, $index, $widget) {
                                                    $jaksa = PdmJaksaP16a::findAll(['no_surat_p16a'=>$model->no_surat_p16a]);
                                                    $no = 1;
                                                    foreach($jaksa as $data){
                                                            $isi .= $no."&nbsp;".$data->nama."<br/>";
                                                            $no++;
                                                    }
                                return $isi;
                            },
                        ],
                                
                                    
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{my_action}',
                            'buttons' => [
                                            'my_action' => function ($url, $model) {
                                            return Html::a('Unggah P-16A', $url, 
                                            [
                                                'title' => Yii::t('app', 'My Action'),
                                                'class'=>'unggah_p16a btn btn-primary',
                                                'data-id' => $model['no_surat_p16a']
                                            ]);
                                        }
                                    ],
                            'urlCreator' => function ($action, $model, $key, $index) {
                                if ($action === 'my_action') {
            //                        return Url::to(['user/my-action']);
                                }
                            }
                         ],
                            
                        [
                            'class'=>'kartik\grid\CheckboxColumn',
                                'headerOptions'=>['class'=>'kartik-sheet-style'],
                                'checkboxOptions' => function ($model, $key, $index, $column) {
                                    return ['value' => $model->no_surat_p16a, 'class' => 'checkHapusIndex'];
                                }
                        ],
                                
                    ],
                    'export' => false,
                    'pjax' => true,
                    'responsive' => true,
                    'hover' => true,
                ]);
                ?>
    <?php $form = ActiveForm::begin(['action' => '/pidum/pdm-p16a/unggah/','options' => ['enctype' => 'multipart/form-data']]) ?>
    <div class="modal fade" id="modal-unggah-p16a" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Unggah P-16A</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="no_surat_p16a" name="no_surat_p16a" />
                    <div class="col-md-6">
                        <?php
                        $preview = "";
                        if($model->file_upload!=""){
                            $preview = ["<a href='".$model->file_upload."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
                                         ];
                        }
                        echo FileInput::widget([
                            'name' => 'attachment_3',
                            'id'   =>  'filePicker',
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showCaption' => true,
                                'showRemove' => true,
                                'showUpload' => false,
                                'initialPreview' =>  $preview
                            ],
                        ]);
                        ?>
                        <?= $form->field($model, 'file_upload')->hiddenInput()?>
                        <br>
                        <button type="submit" class='btn btn-success'>Simpan</button>
                        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end() ?>

</div>

<?php
    $js = <<< JS
        
            $(".unggah_p16a").on('click', function(e){
                var p16a_id=$(this).data('id');
                $('#no_surat_p16a').val(p16a_id);
                $("#modal-unggah-p16a").modal({backdrop:"static"});
            });

		
		if($(".empty").text()=='Tidak ada data yang ditemukan.'){
		$(".select-on-check-all").hide();
	}
            
            var handleFileSelect = function(evt) {
                    var files = evt.target.files;
                    var file = files[0];

                    if (files && file) {
                            var reader = new FileReader();
                            // console.log(file);
                            reader.onload = function(readerEvt) {
                                var binaryString = readerEvt.target.result;
                                var mime = "data:"+file.type+";base64,";
                                console.log(mime);
                                document.getElementById("pdmp16a-file_upload").value = mime+btoa(binaryString);
                                // window.open(mime+btoa(binaryString));
                            };
                            reader.readAsBinaryString(file);
                        }
                    };

                    if (window.File && window.FileReader && window.FileList && window.Blob) {
                        document.getElementById('filePicker').addEventListener('change', handleFileSelect, false);
                    } else {
                        alert('The File APIs are not fully supported in this browser.');
                    }
            
            
            
            
        $('td').dblclick(function (e) {
            var id = $(this).closest('tr').data('id');
            if (id ==undefined){
		bootbox.dialog({
                    message: "Maaf tidak terdapat data untuk diubah",
                    buttons:{
                        ya : {
                            label: "OK",
                            className: "btn-warning",
                        }
                    }
                });
            }else{
                var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p16a/update?id="+id;
                $(location).attr('href',url);
            }
        });
            
        
        $('#idUbah').click (function (e) {
            var count =$('.checkHapusIndex:checked').length;
                if (count != 1 ){
                    bootbox.dialog({
                        message: "Silahkan pilih hanya 1 data untuk diubah",
                        buttons:{
                            ya : {
                                label: "OK",
                                className: "btn-warning",
                            }
                        }
                    });
                } else {
                    var id =$('.checkHapusIndex:checked').val();
                    var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-p16a/update?id="+id;
                    $(location).attr('href',url);
                }
        });
            
            
       


JS;

    $this->registerJs($js);
?>