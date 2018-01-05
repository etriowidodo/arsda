<?php

use yii\helpers\Html;
use app\modules\pidum\models\PdmPerpanjanganTahanan;
use app\modules\pidum\models\PdmPerpanjanganTahananSearch;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PdmPerpanjanganTahananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'RT-2';
$this->subtitle = 'Register Surat Perpanjangan Penahanan';
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
<div class="pdm-perpanjangan-tahanan-index">

<?php //echo '<pre>';print_r($searchModel);exit; 
echo $this->render('_search', ['model' => $searchModel]); ?>

    <div id="divTambah" class="col-md-10" >
        <?= Html::a('Tambah', ['create'], ['class' => 'btn btn-warning']) ?>
    </div>
    
    <div class="col-md-2 pull-right " >
    <div id="divUbah" class="col-md-4">
    <button class='btn btn-success btnUbahCheckboxIndex'>Ubah</button>

     </div>
     <?php
               $form = \kartik\widgets\ActiveForm::begin([
                    'id' => 'hapus-index',
                    'action' => '/pidum/pdm-perpanjangan-tahanan/delete'
                ]);  
            ?> 
        <div id="divHapus" class="col-md-6">
            
            <button class='btn btn-danger btnHapusCheckboxIndex'>Hapus</button>
             
        </div>
    <?php \kartik\widgets\ActiveForm::end() ?>
    </div>
    
    <div class="clearfix"><br><br><br></div>

    <?= GridView::widget(
        [
        
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id']];
        },
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           
			[
                'attribute'=>'no_surat',
                'header' => 'Permintaan dari <br> No. Tgl Surat Permintaan <br> Tanggal diterima',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['akronim'].'<br>'.$model['no_surat'].'<br>'.date("d-m-Y", strtotime($model['tgl_surat']));
                },


            ],

            [
                'attribute'=>'tersangka',
                'header' => 'Tersangka<br> Nomor (T4)/(T5), Tanggal',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    if($model[stax]<>''){
                        $no_t = explode('^', $model[stax]);
                        $hh  =' (T4)';
                        $tgl = date("d-m-Y", strtotime($model['tgl_t4']));
                        if($no_t[1]==',DITOLAK'){
                            $hh=' (T5)';
                            $tgl ='';
                        }    
                    }
                    
                    return $model['nama'].'<br>'.$no_t[0].$hh.'<br>'.$tgl;
                },


            ],

			[
                'attribute'=>'perpanjangan',
                'header' => 'Perpanjangan Penahanan <br> ......  s.d  ......',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    if($model['stax']<>''){
                        $status = explode('^', $model[stax]);
                        if($status[1]==',DITOLAK'){
                            return '';
                        }else{
                            return date("d-m-Y", strtotime($status[1])).' S.D '.date("d-m-Y", strtotime($status[2]));
                        }    
                    }else{

                        return '';
                    }
                    
                },


            ],    
             [
                'attribute'=>'tgl_terima',
                'label' => 'Tempat Penahanan',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    //return \Yii::$app->globalfunc->getNamaSatker($model->terima_dari)->inst_nama;
                    return $model['lokasi_penahanan'];
                },


            ],
			
             
                [
                'class'=>'kartik\grid\CheckboxColumn',
                    'headerOptions'=>['class'=>'kartik-sheet-style'],
                    'checkboxOptions' => function ($model, $key, $index, $column) {
                        return ['value' => $model['id'], 'class' => 'checkHapusIndex'];
                }
            ],
        ],
        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
        /*'panel' => [
            'type' => GridView::TYPE_SUCCESS,
            'heading' => '<i class="glyphicon glyphicon-th-list"></i>',
        ],*/
    ]); 
        
        
       /* [
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_perkara',
            'no_surat',
            'tgl_surat',
            'terima_dari',
            // 'status_perpanjangan',

            ['class' => 'yii\grid\ActionColumn',
			'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', 'update?id='.$model['id_perkara'], [ 'style' => 'color:#4cc521;',
                            'title' => Yii::t('app', 'Update'),
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'delete?id='.$model['id_perkara'], [ 'style' => 'color:#4cc521;',
                            'title' => Yii::t('app', 'New Action1'),
                        ]);
                    }
                ],],
        ],
    ]);*/ ?>

</div>
   </div>
</section>
<?php

 
    $js = <<< JS
            
            
        $(document).ready(function(){
			$('body').addClass('fixed sidebar-collapse');
		});
            
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
			var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-perpanjangan-tahanan/update?id="+id;
			$(location).attr('href',url);
		}
    });
	
    if($('.empty').length>0)
    {
        $('.select-on-check-all').hide();
    }

    $(document).on('change',function(){
        var length_check = $('.checkHapusIndex:checked').length;
        if(length_check==1)
        {
             $('.btnUbahCheckboxIndex').removeAttr('disabled');
        
        }
        if(length_check > 1||length_check==0)
        {

            $('.btnUbahCheckboxIndex').prop('disabled','true');
        }
    }); 

    $('.btnUbahCheckboxIndex').click(function(){
        var id = $('.checkHapusIndex:checked').val();
        var url = window.location.protocol + "//" + window.location.host + "/pidum/pdm-perpanjangan-tahanan/update?id="+id;
        $(location).attr('href',url);
    });
    $(".btnHapusCheckboxIndex").prop("disabled",true);
JS;

    $this->registerJs($js);
?>