<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GroupUserModel;
use Myth\Auth\Models\GroupModel;
use App\Models\CheckinModel;
use App\Models\PromoModel;
use App\Models\MemberCategoryModel;
use App\Models\ActivityModel;

class Account extends BaseController
{
    protected $auth;
    protected $config;

    public function __construct()
    {
        $this->config = config('Auth');
        $this->auth   = service('authentication');
    }
    
    public function index()
    {
        $data                   = $this->data;
        $data['title']          = lang('Global.myAccount');
        $data['description']    = lang('Global.myAccDesc');

        return view('myaccount', $data);
    }

    public function updateaccount()
    {
        // Calling Models & Entities
        $UserModel = new UserModel();

        // Populating Data
        $input = $this->request->getPost();
        $user = $UserModel->find($this->data['uid']);

        // Validating Data
        $rules = [
            'username'      => 'required|alpha_numeric_space|min_length[3]|max_length[30]',
            'email'         => 'required|valid_email',
            'firstname'     => 'required',
            'lastname'      => 'required'
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Saving Data
        $user->username  = $input['username'];
        $user->firstname = $input['firstname'];
        $user->lastname  = $input['lastname'];
        $user->email     = $input['email'];
        $UserModel->save($user);

        // Redirecting
        return redirect()->back()->with('message', 'data has been saved');
    }

    public function newmember()
    {
        // Calling Model
        $GroupModel = new GroupModel();

        // Populating Data
        $groups = $GroupModel->findAll();

        // Parsing Data to View
        $data                   = $this->data;
        $data['title']          = lang('Global.newMember');
        $data['description']    = lang('Global.newMemberDesc');
        $data['groups']         = $groups;

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
        $ActivityModel = new ActivityModel();

        // Populating Data
        $input = $this->request->getPost();

        // Validating Input Data
        $rules = [
            'firstname'     => 'required',
            'lastname'      => 'required',
            'email'         => 'required|valid_email|is_unique[users.email]',
            'phone'         => 'required|numeric',
            'role'          => 'required',
            'expire'        => 'required',
            'photo'         => 'required'
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput($input)->with('errors', $this->validator->getErrors());
        }

        // New User Data
        $newMember->generateMemberId();
        $newMember->username    = $newMember->memberid;
        $newMember->firstname   = $input['firstname'];
        $newMember->lastname    = $input['lastname'];
        $newMember->email       = $input['email'];
        $newMember->phone       = $input['phone'];
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

        // Recording Activity
        $activity = [
            'user_id'   => $this->data['uid'],
            'activity'  => 'Create new member '.$newMember->memberid,
            'done_at'   => date('Y-m-d H:i:s')
        ];
        $ActivityModel->save($activity);

        // Redirecting
        return redirect()->to('users/checkin?memberid='.$newMember->memberid)->with('message', lang('Global.memberCreated'));
    }

    public function list()
    {
        // Calling Services
        $pager = \Config\Services::pager();

        // Calling Models
        $UserModel          = new UserModel();
        $GroupUserModel     = new GroupUserModel();
        $GroupModel         = new GroupModel();

        // Populating Data
        $input = $this->request->getGet();
        
        if (isset($input['sort'])) {
            $sort = $input['sort'];
        } else {
            $sort = 10;
        }

        $excludeRole = [];
        $owners = $GroupUserModel->where('group_id', '2')->find();
        $managers = $GroupUserModel->where('group_id', '3')->find();

        if ((isset($input['role'])) && ($input['role'] != '0') && (empty($input['search']))) {
            $userids = array();
            $GroupUser = $GroupUserModel->where('group_id', $input['role'])->find();
            foreach ($GroupUser as $GroupUser) {
                $userids[] = $GroupUser['user_id'];
            }
            if (!empty($userids)) {
                $users = $UserModel->whereIn('id', $userids)->paginate($sort, 'users');
            } else {
                $users = $UserModel->where('id', '0')->paginate($sort, 'users');
            }
        } elseif ((isset($input['role'])) && ($input['role'] != '0') && (isset($input['search']) && !empty($input['search']))) {
            $userids = array();
            $GroupUser = $GroupUserModel->where('group_id', $input['role'])->find();
            foreach ($GroupUser as $GroupUser) {
                $userids[] = $GroupUser['user_id'];
            }
            $searchArr = [
                'firstname'     => $input['search'],
                'lastname'      => $input['search'],
                'username'      => $input['search']
            ];
            if (!empty($userids)) {
                $users = $UserModel->whereIn('id', $userids)->where('firstname', $input['search'])->orWhere('lastname', $input['search'])->orWhere('username', $input['search'])->paginate($sort, 'users');
            } else {
                $users = $UserModel->where('id', '0')->paginate($sort, 'users');
            }
        } elseif (((empty($input['role'])) || ($input['role'] === '0')) && (isset($input['search']) && !empty($input['search']))) {
            if ($this->data['role'] === 'manager') {
                foreach ($owners as $owner) {
                    $excludeRole[] = $owner['user_id'];
                }
            } elseif ($this->data['role'] === 'staff') {
                foreach ($owners as $owner) {
                    $excludeRole[] = $owner['user_id'];
                }
                foreach ($managers as $manager) {
                    $excludeRole[] = $manager['user_id'];
                }
            }
            if (empty($excludeRole)) {
                $users = $UserModel->where('firstname', $input['search'])->orWhere('lastname', $input['search'])->orWhere('username', $input['search'])->paginate($sort, 'users');
            } else {
                $users = $UserModel->where('firstname', $input['search'])->orWhere('lastname', $input['search'])->orWhere('username', $input['search'])->whereNotIn('id', $excludeRole)->paginate($sort, 'users');
            }
        } else {
            if ($this->data['role'] === 'manager') {
                foreach ($owners as $owner) {
                    $excludeRole[] = $owner['user_id'];
                }
            } elseif ($this->data['role'] === 'staff') {
                foreach ($owners as $owner) {
                    $excludeRole[] = $owner['user_id'];
                }
                foreach ($managers as $manager) {
                    $excludeRole[] = $manager['user_id'];
                }
            }
            if (empty($excludeRole)) {
                $users = $UserModel->paginate($sort, 'users');
            } else {
                $users = $UserModel->whereNotIn('id', $excludeRole)->paginate($sort, 'users');
            }
        }

        if (isset($input['role'])) {
            $dispInput = $input;
        } else {
            $dispInput = [
                'role'      => '',
                'search'    => '',
                'sort'      => ''
            ];
        }

        $data                   = $this->data;
        $data['title']          = lang('Global.memberList');
        $data['description']    = lang('Global.memberListDesc');
        $data['users']          = $users;
        $data['groups']         = $GroupModel->findAll();
        $data['pager']          = $UserModel->pager;
        $data['input']          = $dispInput;

        return view('userlist', $data);
    }

    public function update($memberid)
    {
        // Calling Models
        $UserModel = new UserModel();
        $GroupModel = new GroupModel();
        $GroupUserModel = new GroupUserModel();

        // Populating Data
        $user = $UserModel->where('memberid', $memberid)->first();

        // Parsing Data to View
        $data                   = $this->data;
        $data['title']          = lang('Global.updateMember');
        $data['description']    = lang('Global.updateMemberDesc');
        $data['user']           = $user;
        $data['userrole']       = $GroupUserModel->where('user_id', $user->id)->first();
        $data['groups']         = $GroupModel->findAll();

        // Rendering View
        return view('updatemember', $data);
    }

    public function updating()
    {
        // Calling Libraries
        $authorize = service('authorization');
        
        // Calling Models & Entities
        // $UpdateUser = new \App\Entities\User();
        $UserModel = new UserModel();
        $GroupUserModel = new GroupUserModel();
        $ActivityModel = new ActivityModel();

        // Populating Data
        $input = $this->request->getPost();
        $user = $UserModel->where('memberid', $input['memberid'])->first();
        $UpdateUser = $UserModel->find($user->id);
        $group = $GroupUserModel->where('user_id', $user->id)->first();

        // Validating Input Data
        $rules = [
            'firstname'     => 'required',
            'lastname'      => 'required',
            'role'          => 'required',
            'expire'        => 'required'
        ];

        if (!empty($input['email'])) {
            $rules['email'] = 'valid_email';
        }

        if (!empty($input['phone'])) {
            $rules['phone'] = 'numeric';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput($input)->with('errors', $this->validator->getErrors());
        }

        // Saving Member Data
        $UpdateUser->firstname      = $input['firstname'];
        $UpdateUser->lastname       = $input['lastname'];
        $UpdateUser->expired_at     = date('Y-m-d H:i:s', strtotime($input['expire']));

        if (!empty($input['email'])) {
            $UpdateUser->email = $input['email'];
        }

        if (!empty($input['phone'])) {
            $UpdateUser->phone = $input['phone'];
        }

        $compareForm = [
            'firstname'     => $input['firstname'],
            'lastname'      => $input['lastname'],
            'expire'        => date('Y-m-d H:i:s', strtotime($input['expire'])),
        ];
        if (!empty($input['email'])) {
            $compareForm['email'] = $input['email'];
        }
        if (!empty($input['phone'])) {
            $compareForm['phone'] = $input['phone'];
        }

        $compareUser = [
            'firstname'     => $user->firstname,
            'lastname'      => $user->lastname,
            'expire'        => $user->expired_at,
        ];
        if (!empty($input['email'])) {
            $compareUser['email'] = $user->email;
        }
        if (!empty($input['phone'])) {
            $compareUser['phone'] = $user->phone;
        }

        $formDiff = array_diff($compareForm,$compareUser);

        if (!empty($input['photo'])) {
            $image_parts = explode(";base64,", $input['photo']);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fileName = $user->memberid.'-photo.jpg';
            $file = FCPATH.'/images/member/'.$fileName;
            file_put_contents($file, $image_base64);

            $UpdateUser->photo = $fileName;
        }

        if (!empty($formDiff)) {
            $UserModel->save($UpdateUser);
        }
        
        // Asign Member to New Group
        $authorize->removeUserFromGroup($user->id, $group['group_id']);
        $authorize->addUserToGroup($user->id, $input['role']);

        // Recording Activity
        $activity = [
            'user_id'   => $this->data['uid'],
            'activity'  => 'Update member '.$user->memberid,
            'done_at'   => date('Y-m-d H:i:s')
        ];
        $ActivityModel->save($activity);

        // Redirectiong
        return redirect()->back()->with('message', lang('Global.memberUpdated'));
    }

    public function delete()
    {
        // Calling Models
        $UserModel = new UserModel();
        $ActivityModel = new ActivityModel();

        // Populating Data
        $input = $this->request->getPost();
        $user = $UserModel->where('memberid', $input['memberid'])->first();

        // Deleting Member
        $UserModel->delete($user->id);

        // Recording Activity
        $activity = [
            'user_id'   => $this->data['uid'],
            'activity'  => 'Delete member '.$user->memberid,
            'done_at'   => date('Y-m-d H:i:s')
        ];
        $ActivityModel->save($activity);

        // Redirecting
        return redirect()->back()->with('error', lang('Global.memberDeleted'));
    }

    public function checkin()
    {
        // Calling Services
        $session = \Config\Services::session();

        // Calling Model
        $UserModel = new UserModel();
        $PromoModel = new PromoModel();

        // Populating Data
        $input = $this->request->getGet('memberid');
        if (isset($input)) {
            $user = $UserModel->where('memberid', $input)->first();
            if (!empty($user)) {
                $member = $user;
                if ($user->photo === null) {
                    $session->setTempdata('error', lang('Global.noPhotoCheckIn'), 5);
                }
            } else {
                $member = '';
            }
        }

        // Parsing Data to View
        $data                   = $this->data;
        $data['title']          = lang('Global.checkIn');
        $data['description']    = lang('Global.checkInDesc');
        if (isset($input)) {
            $data['user']       = $member;
            $data['userpromo']  = $PromoModel->getUserPromo($member->id);
        };        
        $data['promos']         = $PromoModel->withDeleted()->findAll();

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
        $UserModel = new UserModel();
        $CheckinModel = new CheckinModel();
        $ActivityModel = new ActivityModel();

        // Populating Data
        $input = $this->request->getPost('id');
        $user = $UserModel->find($input);

        // Saving Data
        $fields = [
            'user_id'       => $input,
            'checked_at'    => date('Y-m-d H:i:s')
        ];
        $CheckinModel->save($fields);

        // Recording Activity
        $activity = [
            'user_id'   => $this->data['uid'],
            'activity'  => 'Check-In member '.$user->memberid,
            'done_at'   => date('Y-m-d H:i:s')
        ];
        $ActivityModel->save($activity);

        // Redirectiong
        return redirect()->to('users/checkin')->with('message', lang('Global.memberCheckedIn'));
    }

    public function extend()
    {
        // Calling Model
        $UserModel = new UserModel();
        $PromoModel = new PromoModel();

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
        $data['title']          = lang('Global.extend');
        $data['description']    = lang('Global.extendDesc');
        if (isset($input)) {
            $data['user'] = $member;
            $data['promos'] = $PromoModel->findAll();
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
        $UserModel = new UserModel();
        $ActivityModel = new ActivityModel();
        $PromoModel = new PromoModel();

        // Populating Data
        $input = $this->request->getPost();
        $user = $UserModel->find($input['id']);

        // Saving User Data
        $user->sub_type     = $input['sub_type'];
        $user->expired_at   = date('Y-m-d H:i:s', strtotime($input['expire']));
        $UserModel->save($user);

        // Updating Promo
        if ($input['sub_type'] === '0') {
            $PromoModel->deleteUserPromo($input['id']);
        } elseif ($input['sub_type'] === '1') {
            $PromoModel->addUserPromo($input['id'], $input['promoid']);
        }

        // Recording Activity
        $activity = [
            'user_id'   => $this->data['uid'],
            'activity'  => 'Extend membership '.$user->memberid,
            'done_at'   => date('Y-m-d H:i:s')
        ];
        $ActivityModel->save($activity);

        // Redirecting
        return redirect()->to('dashboard')->with('message', lang('Global.memberExtended'));
    }

    public function category()
    {
        // Calling Models $ Services
        $pager                  = \Config\Services::pager();
        $MemberCategoryModel    = new MemberCategoryModel();

        // Parsing Data to View
        $data                   = $this->data;
        $data['title']          = lang('Global.categoryList');
        $data['description']    = lang('Global.categoryListDesc');
        $data['promos']         = $MemberCategoryModel->paginate(10, 'promos');
        $data['pager']          = $MemberCategoryModel->pager;

        // Rendering View
        return view('promo', $data);
    }
}
