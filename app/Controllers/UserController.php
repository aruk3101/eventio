<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    public function __construct()
    {
        helper('form');
    }

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

    public function submitRegister()
    {
        // Walidacja danych
        $validation = \Config\Services::validation();

        //zasady walidacji
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[20]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ]);

        //uruchomienie walidacji i otrzymanie wyników
        if (!$validation->withRequest($this->request)->run()) {
            //przekierowanie jeżeli błędy walidacji
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        // Przygotowanie danych do insercji
        $userData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'hashed_password' => $hashedPassword
        ];

        // Zapisanie użytkownika w bazie
        $userModel = new UserModel();
        $userModel->registerUser($userData);

        // sukces i przekierowanie
        return redirect()->to('/user/register')->with('message', 'Zarejestrowany pomyślnie! Teraz możesz się zalogować.');
    }
}
