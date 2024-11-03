<?php

namespace App\Controllers;

class UserController extends BaseController
{
    public function returnView($pageName = 'login', $content = array())
    {
        $data =  [
            'header' => view('common/header'),
            'footer' => view('common/footer'),
            'menu' => view('common/menu'),
            'content' => view($pageName, $content),
            'submenu' => '',
            'baseCss' => view('common/baseCss'),
            'css' => ''
        ];

        return view(
            "common/basePage",
            $data
        );
    }

    public function index(): string
    {
        return $this->returnView('user/userPage');
    }

    public function login(): string
    {
        return $this->returnView('user/login');
    }

    public function register(): string
    {
        return $this->returnView('user/register');
    }
}
