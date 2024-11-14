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

    public function index()
    {
        if (!session()->has("loggedUser")) {
            return redirect()->to('/user/login')->with('errors', ['Musisz być zalogowany aby wejść na profil użytkownika']);
        } else {
            $userModel = new UserModel();
            $user = $userModel->getLoggedInUser();
            return $this->returnView('user/userPage', ['user' => $user]);
        }
    }


    public function edit()
    {
        if (!session()->has("loggedUser")) {
            return redirect()->to('/user/login')->with('errors', ['Musisz być zalogowany, aby edytować swoje dane.']);
        } else {
            $userModel = new UserModel();
            $user = $userModel->getLoggedInUser();
            return $this->returnView('user/edit', ['user' => $user]);
        }
    }

    public function submitEdit()
    {
        if (!session()->has('loggedUser')) {
            return redirect()->to('/user/login')->with('errors', ['Musisz być zalogowany, aby edytować swoje dane.']);
        }

        $userId = session()->get('loggedUser');
        $userModel = new UserModel();

        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]',
            'email'    => 'required|valid_email',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ];

        $userModel->updateUser($userId, $data);

        return redirect()->to('/user')->with('message', 'Dane zostały zaktualizowane pomyślnie!');
    }

    public function login(): string
    {
        return $this->returnView('user/login');
    }

    public function submitLogin()
    {
        // Walidacja danych logowania
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new UserModel();
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->verifyUser($email, $password);

        if ($user) {
            session()->set('loggedUser', $user['user_id']);
            return redirect()->to('/user')->with('message', 'Zalogowano pomyślnie!');
        } else {
            return redirect()->back()->withInput()->with('errors', ['Błędny e-mail lub hasło.']);
        }
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

    public function logout()
    {
        session()->destroy(); // Zniszczenie sesji
        return redirect()->to('/user/login')->with('message', 'Wylogowano pomyślnie!');
    }
}
