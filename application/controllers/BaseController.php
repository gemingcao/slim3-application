<?php
namespace App\Controllers;

use Orx0r\Slim\Controller\Controller;

class BaseController extends Controller
{
    protected function baseAction()
    {
        $csrfName      = $this->request->getAttribute('csrf_name');
        $csrfValue     = $this->request->getAttribute('csrf_value');

        $thisViewArgs = [
            'CSRF_NAME'  => $csrfName,
            'CSRF_VALUE' => $csrfValue,
        ];
        foreach ($thisViewArgs as $key => $value) {
            $this->container['view']['twig']->addGlobal($key, $value);
        }
    }
}