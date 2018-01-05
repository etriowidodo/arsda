<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmT8Search */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p29-index">

    <div id="divTambah" class="col-md-11">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>

    <?php
    $form = \kartik\widgets\ActiveForm::begin([
                'id' => 'hapus-index',
                'action' => '/pdsold/pdm-p29/delete'
    ]);
    ?>
    <div id="divHapus" class="col-md-1">
        <button class='btn btn-warning btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>

    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['no_register_perkara']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'no_register_perkara',
                'label' => 'Nomor Register Perkara',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_register_perkara;
                },
            ],
            [
                'attribute'=>'tgl_dikeluarkan',
                'label' => 'Tanggal Dikeluarkan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return date("d-m-Y", strtotime($model->tgl_dikeluarkan));
                },
            ],
            [
                'attribute'=>'dakwaan',
                'label' => 'Dakwaan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->dakwaan;
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{my_action}',
                'buttons' => [
                                'my_action' => function ($url, $model) {
                                return Html::a('Unggah P-29', $url, 
                                [
                                    'title' => Yii::t('app', 'My Action'),
                                    'class'=>'unggah_p29 btn btn-primary',
                                    'data-id' => $model['no_register_perkara']
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
                'class' => 'kartik\grid\CheckboxColumn',
                'headerOptions' => ['class' => 'kartik-sheet-style'],
                'checkboxOptions' => function ($model, $key, $index, $column) {
            return ['value' => $model->no_register_perkara, 'class' => 'checkHapusIndex'];
        }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive' => true,
        'hover' => true,
    ]); ?>
    
    <?php $form = ActiveForm::begin(['action' => '/pdsold/pdm-p29/unggah/','options' => ['enctype' => 'multipart/form-data']]) ?>
    <div class="modal fade" id="modal-unggah-p29" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Unggah P-29</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="no_register_perkara" name="no_register_perkara" />
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
            
               
        $('td').dblclick(function (e) {
        var no_register = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p29/update?no_register="+no_register;
        $(location).attr('href',url);
    });
            
            $(".unggah_p29").on('click', function(e){
                var p29_id=$(this).data('id');
                $('#no_register_perkara').val(p29_id);
                $("#modal-unggah-p29").modal({backdrop:"static"});
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
                                document.getElementById("pdmp29-file_upload").value = mime+btoa(binaryString);
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
            
            
            
         


JS;

    $this->registerJs($js);
?>