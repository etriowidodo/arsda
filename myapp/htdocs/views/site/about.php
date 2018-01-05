<?php
use yii\data\ActiveDataProvider;
use app\models\User;
use app\models\P16;

$model_ids = array(array($model->id, User::className()));


$criteria = \sammaye\audittrail\AuditTrail::find();
$param_id = 0;

// $model_ids is the one you built in your original code
foreach( $model_ids as $id_pair ) {
    $criteria->orWhere('model_id = :id' . $param_id . ' AND model = :model' . $param_id);
    $criteria->addParams([
        ':id' . $param_id => $id_pair[0], 
        ':model' . $param_id => $id_pair[1]
    ]);
    $param_id++;
}
$criteria->orderBy(['stamp' => SORT_DESC]);

echo yii\grid\GridView::widget([
    'dataProvider' => new ActiveDataProvider([
        'query' => $criteria,
        'pagination' => [
            'pageSize' => 100,
        ]
    ]),
    'columns' => [
        [
            'label' => 'Author',
            'value' => function($model, $index, $widget){
                return $model->user ? $model->user->email : "";
            }
        ],
        [
            'attribute' => 'model',
            'value' => function($model, $index, $widget){
                $p = explode('\\', $model->model);
                return end($p);
            }
        ],
        'model_id',
        'action',
        [
            'label' => 'field',
            'value' => function($model, $index, $widget){
                return $model->getParent()->getAttributeLabel($model->field);
            }
        ],
        'old_value',
        'new_value',
        [
            'label' => 'Date Changed',
            'value' => function($model, $index, $widget){
                return date("d-m-Y H:i:s", strtotime($model->stamp));
            }
        ]
    ]
]); ?>