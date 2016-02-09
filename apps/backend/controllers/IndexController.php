<?php

namespace Backend\Controllers;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        $model = new \Backend\Models\Model();
        var_dump($model->id);exit;
    }
}
