<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    public function index(): string
    {
        $user = (new UserModel())->orderBy('id', 'ASC')->first();

        return view('partials/header', ['pageTitle' => 'Profile', 'activePage' => 'profile'])
            . view('profile', ['user' => $user])
            . view('partials/footer');
    }
}
