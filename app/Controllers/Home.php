<?php

namespace App\Controllers;

use Myth\Auth\Models\GroupModel;

class Home extends BaseController
{
    public function index()
    {
        $data                   = $this->data;
        if ($data['role'] === 'member') {
            return redirect()->to('myaccount');
        } else {
            return redirect()->to('dashboard');
        }
    }

    public function trial()
    {
        $authorize = service('authorization');
        $authorize->updateGroup('3', 'manager', '');
        $authorize->createGroup('staff', '');
        $authorize->createGroup('personal trainer', '');
    }

    public function dashboard()
    {
        $data                   = $this->data;
        $data['title']          = lang('Global.dashboard');
        $data['description']    = lang('Global.dashdesc');

        return view('dashboard', $data);
    }

    public function phpinfo()
    {
        dd(date('Y-m-d H:i:s', strtotime('2023-07-31')));
        //phpinfo();
    }

    public function migration()
    {
        echo command('migrate -all');
    }

    public function update()
    {
        $authorize = service('authorization');
        $authorize->updateGroup('3', 'manager', '');
        $authorize->createGroup('staff', '');
        $authorize->createGroup('personal trainer', '');
    }
}
