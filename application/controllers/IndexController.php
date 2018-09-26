<?php
namespace App\Controllers;

class IndexController extends BaseController
{
    public function actionHello($name = null)
    {
        $thisViewArgs = [
            'title' => 'Slim Framework 3 Gemingcao Application',
            'name' => $name,
        ];
        return $this->render('default/home/index.html', $thisViewArgs);
    }
}