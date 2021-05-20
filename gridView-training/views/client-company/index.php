<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ClientCompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client Companies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-company-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Client Company', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        ###!!! dla wartości null wyświetlam '-'
        'formatter' => [
            'class' => \yii\i18n\Formatter::class,
            'nullDisplay' => '-'
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            ###!!! person dla przykładu zostawiam jako select
            [
                'attribute' => 'person_id',
                'value' => 'person.person_name',
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Person::find()->all(), 'id', 'person_name')
            ],
            [
                'attribute' => 'user_name',
                'value' => 'user.user_name'
            ],
            'company_name',
            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
