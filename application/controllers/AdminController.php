<?php
namespace App\Controllers;

use App\Models\TestModel;

class AdminController extends BaseController
{
    public function actionWelcome()
    {
        $this->baseAction();
        $test = TestModel::all();
        $thisViewArgs = [
            'title'     => '后台管理',
            'test' => $test,
        ];
        $this->session->set('test', 'hello world!');
        $this->cookie->set('test', 'hello world!');
        return $this->render('default/admin/index.html', $thisViewArgs);
    }
}