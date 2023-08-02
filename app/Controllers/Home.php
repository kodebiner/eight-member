<?php

namespace App\Controllers;

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
        $GroupUserModel = new \App\Models\GroupUserModel();

        $authorize->removeUserFromGroup('6', '1');
        $authorize->addUserToGroup('6', '2');
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
}
