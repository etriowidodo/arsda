<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'PENUNTUTAN';
//$this->subtitle = 'Surat Pemberitahuan Dimulainya Penyidikan';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if(Yii::$app->session->getFlash('message') != null): ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>	<i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('message'); ?></h4>
</div>
<?php endif ?>

<div class="pidum-pdm-spdp-index">

    
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>

    <?= GridView::widget([
        'id' => 'penuntutan',
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model['id_perkara']];
        },
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'no_surat',
                'label' => 'No dan Tanggal SPDP',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
                    return $model['no_surat']."<br>".date('d-m-Y', strtotime($model['tgl_surat']));
                },


            ],

            ['label'=>'Didakwa Melanggar UU dan PASAL',
            'value'=>function ($data) {
                            return $data['undang'];
                            },
            'format' => 'html', 		
            ],

            ['label'=>'Terdakwa',
            'value'=>function ($data) {
                    $resultTersangkas = "";
                        $tersangkas = explode("#", $data['tersangka']);
                        if(count($tersangkas)>5){
                                for($i = 1; $i <= 6; $i++){
                                                if($i <= 5){
                                                        $resultTersangkas .= $i . ". " . $tersangkas[$i-1] . "<BR>";
                                                }else{
                                                        $resultTersangkas .= $i . ". dkk";
                                                }
                                        }
                        }else{
                                for($i = 1; $i <= count($tersangkas); $i++){
                                                $resultTersangkas .= $i . ". " . $tersangkas[$i-1] . "<BR>";
                                }
                        }
                        return $resultTersangkas;
                    },
            'format' => 'html', 		
            ],

            ['label'=>'Status',
            'value'=>function ($data) {
                            return $data['status'];
                            },
            'format' => 'html', 		
            ],
        ],

        'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
        
    ]); ?>

</div>
<?php
    $js = <<< JS
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/penuntutan/update?id="+id;
        $(location).attr('href',url);
    });


JS;

    $this->registerJs($js);
