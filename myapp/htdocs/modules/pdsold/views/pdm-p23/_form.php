<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPenandatangan;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP17 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
    <?php
    $form = ActiveForm::begin(
        [
            'options' => ['enctype' => 'multipart/form-data'],
            'id' => 'p23-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'labelSpan' => 1,
                'showLabels' => false

            ]
        ]);
    ?>
	<?php
    $date_awal  = date('Y-m-d');

    $date_akhir = date_create((date('Y-m-d',strtotime($p22->tgl_dikeluarkan))));
    date_add($date_akhir, date_interval_create_from_date_string('14 days'));
    $date_akhir = $date_akhir->format('Y-m-d');

	 ?>
        <?= $this->render('//default/_formHeader3', ['form' => $form, 'model' => $model]) ?>

        <div  class="box box-primary" style="border-color: #f39c12;padding-bottom: 15px;">
 
            <br>
			<div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-sm-2">Nomor P22</label>

                <div class="col-sm-3"><input type="text" class="form-control" value="<?= $p22->no_surat ?>"
                                             readonly="true">
                </div>
                <label class="control-label col-sm-2" style="width: 10%;">Tanggal P22</label>

                <div class="col-sm-3" style="width: 10%;"><input type="text" class="form-control"
                                             value="<?= date('d-m-Y', strtotime($p22->tgl_dikeluarkan)) ?>" readonly="true">
                </div>
				</div>
            </div>
        </div>
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
         
		
		 <p><h4>Tersangka</h4><p>
		  <?= GridView::widget([
	   'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
	   'rowOptions'   => function ($model, $key, $index, $grid) {
	
            return ['data-id' => $model['id_tersangka']];	
        },
        'columns' => [
          
		   [
                'attribute'=>'namaTersangka',
                'label' => 'Nama',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				return ($model[namaTersangka]);

                },

            ],
		   [
                'attribute'=>'tgl_lahir',
                'label' => 'Tanggal Lahir',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				return (date('d-m-Y',strtotime($model[tgl_lahir]))) ;
		

                },

            ],
			 [
                'attribute'=>'umur',
                'label' => 'Umur',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				return ($model[umur]);

                },

            ],
			 [
                'attribute'=>'nama',
                'label' => 'Jenis Kelamin',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				return ($model[nama]);

                },

            ],
			
        ],
		     'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
		
    ]); ?>

	 </div>
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P23, 'id_table' => $model->id_p23]) ?>

    <div class="box-footer" style="text-align: center;">
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
        <?php if(!$model->isNewRecord){ ?>
			<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p23/cetak?idp23='.$model->id_p23])?>">Cetak</a>
			<button id='hapus' type="button" class="btn btn-danger" >Hapus</button>
		<?php } ?>
		<?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pdsold/pdm-p23/index'], ['class' => 'btn btn-danger']) ?>

    </div>
    <input id="tmp_id" type="hidden" value="<?php echo $model['id_pengantar']; ?>">

    <?php ActiveForm::end(); ?>

</div>
</section>

<?php

$now = date('d-m-Y');
$script = <<< JS
			$('.summary').remove();
			
            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<input type="text" class="form-control" style="margin-left:180px"name="mytext[]"><br />'
                )
            });
			
              $(document).ready(function(){
                    var date_awal = Date.parse('$date_awal');
                    var date_akhir = Date.parse('$date_akhir');
                    console.log((date_awal>date_akhir)?"TRUE":"FALSE");
                    // console.log(date_akhir);
                    if (date_awal < date_akhir)
                    {
                     bootbox.dialog({
                            message: "Anda Belum Dapat Melakukan Input P23, Karena Tanggal Belum Melebihi 14 Hari Dari Tanggal  P22",
                            buttons:{
                                ya : {
                                    label: "OK",
                                    className: "btn-warning",

                                }
                            }
                        });
                    }
                });
			 $('#hapus').click(function(){
             bootbox.dialog({
                message: "Apakah anda ingin menghapus data ini?",
                buttons:{
                    ya : {
                        label: "Ya",
                        className: "btn-warning",
                        callback: function(){
                           $.ajax({
                                     type       : 'POST',
                                     url        :  '/pdsold/pdm-p23/hapus',
                                     data       : 'hapusIndex='+$('#tmp_id').val(),              
                                     success    : function(data)
                                                {
                                                    location.reload();
                                                }
                                    });
                        }
                    },
                    tidak : {
                        label: "Tidak",
                        className: "btn-warning",
                        callback: function(result){
                        }
                    }
                }
            });
                
        });


        var date        = '$p22->tgl_dikeluarkan';
        // date            = date[2]+'-'+date[1]+'-'+date[0];
        console.log(date);
        var someDate    = new Date(date);
        var endDate     = new Date(date);
        //someDate.setDate(someDate.getDate()+7);
        someDate.setDate(someDate.getDate()+1);
        endDate.setDate(endDate.getDate()+14);
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        console.log(finaldate);
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('.field-pdmp23-tgl_dikeluarkan').html();
        var datecontrol         = $('#pdmp23-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
        $('.field-pdmp23-tgl_dikeluarkan').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':finaldate , 'endDate':'$now','format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmp23-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmp23-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmp23-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
          $('.field-pdmp23-tgl_dikeluarkan').removeClass('.has-error');
          $('#pdmp23-tgl_dikeluarkan-disp').removeAttr('disabled');
JS;
$this->registerJs($script);
?>
<br>
