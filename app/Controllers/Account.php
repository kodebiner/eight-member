<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GroupUserModel;
use Myth\Auth\Models\GroupModel;
use App\Models\CheckinModel;

class Account extends BaseController
{
    public function index()
    {
        $data                   = $this->data;
        $data['title']          = lang('Global.myAccount');
        $data['description']    = lang('Global.myAccDesc');

        return view('myaccount', $data);
    }

    public function newmember()
    {
        // Calling Model
        $GroupModel = new GroupModel();

        // Populating Data
        $groups = $GroupModel->findAll();

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://restcountries.com/v3.1/all?fields=name,idd");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $country = json_decode(curl_exec($curl), true);
        $countrysort = array_column($country, 'name');
        array_multisort($countrysort, SORT_ASC, $country);
        curl_close($curl);

        // Parsing Data to View
        $data                   = $this->data;
        $data['title']          = lang('Global.myAccount');
        $data['description']    = lang('Global.myAccDesc');
        $data['groups']         = $groups;
        $data['countries']      = $country;

        // Rendering View
        return view('newmember', $data);
    }

    public function createmember()
    {
        // Calling Libraries
        $authorize = service('authorization');
        
        // Calling Models & Entities
        $newMember = new \App\Entities\User();
        $UserModel = new UserModel();

        // Populating Data
        $input = $this->request->getPost();

        // Validating Input Data
        $rules = [
            'firstname'     => 'required|alpha_numeric_punct',
            'lastname'      => 'required|alpha_numeric_punct',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'country-code'  => 'required',
            'phone'         => 'required|numeric',
            'role'          => 'required',
            'expire'        => 'required',
            'photo'         => 'required'
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // New User Data
        $newMember->generateMemberId();
        $newMember->username    = $newMember->memberid;
        $newMember->firstname   = $input['firstname'];
        $newMember->lastname    = $input['lastname'];
        $newMember->email       = $input['email'];
        $newMember->phone       = $input['country-code'].$input['phone'];
        $newMember->expired_at  = date('Y-m-d H:i:s', strtotime($input['expire']));

        $n = 16;
        function getPassword($n) {
            $characters = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*()_-+=';
            $randomString = '';
            for ($i = 0; $i < $n; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $randomString .= $characters[$index];
            }
            return $randomString;
        }
        $newMember->password = getPassword($n);

        $image_parts = explode(";base64,", $input['photo']);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $newMember->memberid.'-photo.jpg';
        $file = FCPATH.'/images/member/'.$fileName;
        file_put_contents($file, $image_base64);
        $newMember->photo = $fileName;

        $newMember->activate();
        $newMember->setForcePassReset(1);
        $newMember->generateResetHash();

        // Saving New User Data
        $UserModel->insert($newMember);

        // Getting New Iser ID
        $userId = $UserModel->getInsertID();

        // Asign New User to a Group
        $authorize->addUserToGroup($userId, $input['role']);

        // Sending Email
        $email = \Config\Services::email();
        $email->attach(FCPATH.'/images/member/'.$newMember->membercard);
        $cid = $email->setAttachmentCID(FCPATH.'/images/member/'.$newMember->membercard);
        $email->setTo($newMember->email);
        $email->setSubject(lang('Auth.activationSubject'));
        $email->setMessage(view('Auth/emails/admnewmember', ['hash' => $newMember->reset_hash, 'username' => $newMember->username, 'cid' => $cid]));
        $email->send();

        // Redirecting
        return redirect()->to('users/checkin?memberid='.$newMember->memberid)->with('message', 'New member has been created');
    }

    public function list()
    {
        // Calling Models
        $UserModel          = new UserModel();
        $GroupUserModel     = new GroupUserModel();
        $GroupModel         = new GroupModel();

        // Populating Data
        $input = $this->request->getGet('role');
        
        if (isset($input)) {
            $userids = array();
            $GroupUser = $GroupUserModel->where('group_id', $input)->find();
            foreach ($GroupUser as $GroupUser) {
                $userids[] = $GroupUser['user_id'];
            }
            $users = $UserModel->whereIn('id', $userids)->find();
        } else {
            $users = $UserModel->findAll();
        }

        $data                   = $this->data;
        $data['title']          = lang('Global.myAccount');
        $data['description']    = lang('Global.myAccDesc');
        $data['users']          = $users;

        return view('userlist', $data);
    }

    public function checkin()
    {
        // Calling Model
        $UserModel = new UserModel();

        // Populating Data
        $input = $this->request->getGet('memberid');
        if (isset($input)) {
            $user = $UserModel->where('memberid', $input)->first();
            if (!empty($user)) {
                $member = $user;
            } else {
                $member = '';
            }
        }

        // Parsing Data to View
        $data                   = $this->data;
        $data['title']          = lang('Global.myAccount');
        $data['description']    = lang('Global.myAccDesc');
        if (isset($input)) {
            $data['user'] = $member;
        };

        // Rendering View
        if (isset($input)) {
            return view('checkedin', $data);
        } else {
            return view('checkin', $data);
        }
    }

    public function checked()
    {
        // Calling Model
        $CheckinModel = new CheckinModel();

        // Populating Data
        $input = $this->request->getPost('id');

        // Saving Data
        $fields = [
            'user_id'       => $input,
            'checked_at'    => date('Y-m-d H:i:s')
        ];
        $CheckinModel->save($fields);

        // Redirectiong
        return redirect()->to('dashboard')->with('message', 'Member has been checked-in');
    }

    public function extend()
    {
        // Calling Model
        $UserModel = new UserModel();

        // Populating Data
        $input = $this->request->getGet('memberid');
        if (isset($input)) {
            $user = $UserModel->where('memberid', $input)->first();
            if (!empty($user)) {
                $member = $user;
            } else {
                $member = '';
            }
        }

        // Parsing Data to View
        $data                   = $this->data;
        $data['title']          = lang('Global.myAccount');
        $data['description']    = lang('Global.myAccDesc');
        if (isset($input)) {
            $data['user'] = $member;
        };

        // Rendering View
        if (isset($input)) {
            return view('extending', $data);
        } else {
            return view('extend', $data);
        }
    }

    public function extending()
    {
        // Calling Models & Entities
        $updateMember = new \App\Entities\User();
        $UserModel = new UserModel();

        // Populating Data
        $input = $this->request->getPost();

        // Saving Data
        $updateMember->id           = $input['id'];
        $updateMember->expired_at   = date('Y-m-d H:i:s', strtotime($input['expire']));
        $UserModel->save($updateMember);

        // Redirecting
        return redirect()->to('dashboard')->with('message', 'Membership has been extended');
    }
}
