<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $data =  [
            'header' => view('common/header'),
            'footer' => view('common/footer'),
            'menu' => view('common/menu'),
            'content' => view('welcome_message'),
            'submenu' => '',
            'baseCss' => view('common/baseCss'),
            'css' => ''
        ];

        return view(
            "common/basePage",
            $data
        );
    }
}
