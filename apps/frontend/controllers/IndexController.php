<?php

namespace Frontend\Controllers;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
        $model = new \Frontend\Models\Model();
        var_dump($model->id);exit;
    }
}
