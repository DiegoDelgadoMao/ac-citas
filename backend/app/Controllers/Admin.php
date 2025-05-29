<?php namespace App\Controllers;

class Admin extends BaseController
{
    public function dashboard()
    {
        return view('admin/dashboard', [
            'title'    => 'Panel Admin',
            'userName' => session('user_name'),
        ]);
    }
}
