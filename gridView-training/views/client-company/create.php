<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ClientCompany */

$this->title = 'Create Client Company';
$this->params['breadcrumbs'][] = ['label' => 'Client Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="client-company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
