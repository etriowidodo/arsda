<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\modules\pdsold\models\PdmJaksaP16;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use app\modules\pdsold\models\PdmP16;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmP16Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p16-index">
    <div id="divTambah" class="col-md-11" style="width:82%;">
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
	<div  class="col-md-1" style="width:6%;">
        <button id="cetak" class='btn btn-primary btnPrintCheckboxIndex' disabled>Cetak</button>
    </div>
    <div  class="col-md-1" style="width:6%;">
        <button id="idUbah" class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>
    </div>
    
    <?php
       $form = \kartik\widgets\ActiveForm::begin([
            'id' => 'hapus-index',
            'action' => '/pdsold/p16/delete/'
        ]);  
    ?>  
    <div id="divHapus" class="col-md-1" style="width:5%; margin-left:0px;">
        <button  class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
    </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    <div class="clearfix"><br><br></div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_p16']];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'no_surat',
                'label' => 'Nomor dan Tanggal Surat',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model->no_surat."<br/>".date("d-m-Y", strtotime($model->tgl_dikeluarkan));
                },


            ],
			[
                'attribute'=>'jaksa',
                'label' => 'Jaksa Peneliti',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
					$jaksa = PdmJaksaP16::findAll(['id_p16'=>$model->id_p16]);
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
                                return Html::a('Unggah P-16', $url, 
                                [
                                    'title' => Yii::t('app', 'My Action'),
                                    'class'=>'unggah_p16 btn btn-primary',
                                    'data-id' => $model['id_p16']
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
                        return ['value' => $model->id_p16, 'class' => 'checkHapusIndex'];
                    }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
    ]); ?>
</div>

<?php $form = ActiveForm::begin(['action' => '/pdsold/p16/unggah/','options' => ['enctype' => 'multipart/form-data']]) ?>
<?php // $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
<div class="modal fade" id="modal-unggah-p16" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Unggah P-16</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_p16" name="id_p16" />
                <?php echo $form->field($model, 'file_upload')->widget(FileInput::classname(), [
                            'options' => ['accept'=>'application/pdf'],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showUpload' => false,
                                'showRemove' => false,
                                'showClose' => false,
                                'showCaption'=> false,
                                'allowedFileExtension' => ['pdf'],
                                'maxFileSize'=> 3027,
                                'browseLabel'=>'Unggah P-16...',
                            ]
                        ]);
                
                ?>
                <br>
                <button type="submit" class='btn btn-success'>Simpan</button>
                <button class="btn btn-danger" data-dismiss="modal" aria-label="Close">Batal</button>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end() ?>


 <?php
        $js = <<< JS
                
                $(".unggah_p16").on('click', function(e){
                        var p16_id=$(this).data('id');
                        $('#id_p16').val(p16_id);
                        $("#modal-unggah-p16").modal({backdrop:"static"});
                });

		
		if($(".empty").text()=='Tidak ada data yang ditemukan.'){
		$(".select-on-check-all").hide();
	}
	
        $('td').dblclick(function (e) {
		var id = $(this).closest('tr').data('id');
		if (id ==undefined)
		{
		bootbox.dialog({
                message: "Maaf tidak terdapat data untuk diubah",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}
		else
        {
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/p16/update?id="+id;
        $(location).attr('href',url);
		}
		});
		
		//Danar Wido Seno 03-08-2016
		
		$('#idUbah').click (function (e) {
        var count =$('.checkHapusIndex:checked').length;
		if (count != 1 )
		{
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
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/p16/update?id="+id;
        $(location).attr('href',url);
		//alert(count);
		}
    });



	
		//End Danar Wido Seno 03-08-2016

    $(document).on('change',function(){
            var length_check = $('.checkHapusIndex:checked').length;
            if(length_check==1)
            {
                 $('.btnPrintCheckboxIndex').removeAttr('disabled');
            
            }
            if(length_check > 1||length_check==0)
            {

                $('.btnPrintCheckboxIndex').prop('disabled','true');
            }
        });

    
    $('.btnPrintCheckboxIndex').click(function(){
            var id_p16 = $('.checkHapusIndex:checked').val();
            var cetak   = 'cetak?id='+id_p16; 
            window.location.href = cetak;
        }); 

// $('body').on('click', 'td', function() {

//     var id = $(this).attr('data-col-seq');
//     alert(id);
// });

	

JS;

        $this->registerJs($js);
        ?>