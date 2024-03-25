<?php

namespace App\Controllers;

use App\Models\CheckinModel;
use App\Models\UserModel;

class Report extends BaseController
{
    public function checkin()
    {
        // Calling Models
        $CheckinModel = new CheckinModel();
        $UserModel = new UserModel();

        // Populating Data
        $input = $this->request->getGet();
        // dd($input);
        $pts = [];
        $personalTrainers = $UserModel->getPT();
        foreach ($personalTrainers as $personalTrainer) {
            $pts[$personalTrainer->id] = $personalTrainer->firstname.' '.$personalTrainer->lastname;
        }

        if (isset($input['sort'])) {
            $sort = $input['sort'];
        } else {
            $sort = 10;
        }

        if (($this->data['role'] != 'personal trainer') && (empty($input['pt']))) {
            if (!empty($input['startdate']) && !empty($input['enddate'])) {
                $startdate = date('Y-m-d H:i:s', strtotime($input['startdate'].' 00:00:00'));
                $enddate = date('Y-m-d H:i:s', strtotime($input['enddate'].' 23:59:59'));
                $checkin = $CheckinModel->where('checked_at >=', $startdate)->where('checked_at  <=', $enddate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('checked_at >=', $startdate)->where('checked_at  <=', $enddate)->find();
                $dispinput = [
                    'startdate' => $input['startdate'],
                    'enddate'   => $input['enddate'],
                    'pt'        => ''
                ];
            } elseif (!empty($input['startdate']) && empty($input['enddate'])) {
                $startdate = date('Y-m-d H:i:s', strtotime($input['startdate'].' 00:00:00'));
                $checkin = $CheckinModel->where('checked_at >=', $startdate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('checked_at >=', $startdate)->find();
                $dispinput = [
                    'startdate' => $input['startdate'],
                    'enddate'   => '',
                    'pt'        => ''
                ];
            } elseif (empty($input['startdate']) && !empty($input['enddate'])) {
                $enddate = date('Y-m-d H:i:s', strtotime($input['enddate'].' 23:59:59'));
                $checkin = $CheckinModel->where('checked_at  <=', $enddate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('checked_at  <=', $enddate)->find();
                $dispinput = [
                    'startdate' => '',
                    'enddate'   => $input['enddate'],
                    'pt'        => ''
                ];
            } else {
                $checkin = $CheckinModel->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->findAll();
                $dispinput = [
                    'startdate' => '',
                    'enddate'   => '',
                    'pt'        => ''
                ];
            }
        } elseif (($this->data['role'] === 'personal trainer') && (empty($input['pt']))) {
            if (!empty($input['startdate']) && !empty($input['enddate'])) {
                $startdate = date('Y-m-d H:i:s', strtotime($input['startdate'].' 00:00:00'));
                $enddate = date('Y-m-d H:i:s', strtotime($input['enddate'].' 23:59:59'));
                $checkin = $CheckinModel->where('pt', $this->data['uid'])->where('checked_at >=', $startdate)->where('checked_at  <=', $enddate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('pt', $this->data['uid'])->where('checked_at >=', $startdate)->where('checked_at  <=', $enddate)->find();
                $dispinput = [
                    'startdate' => $input['startdate'],
                    'enddate'   => $input['enddate']
                ];
            } elseif (!empty($input['startdate']) && empty($input['enddate'])) {
                $startdate = date('Y-m-d H:i:s', strtotime($input['startdate'].' 00:00:00'));
                $checkin = $CheckinModel->where('pt', $this->data['uid'])->where('checked_at >=', $startdate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('pt', $this->data['uid'])->where('checked_at >=', $startdate)->find();
                $dispinput = [
                    'startdate' => $input['startdate'],
                    'enddate'   => ''
                ];
            } elseif (empty($input['startdate']) && !empty($input['enddate'])) {
                $enddate = date('Y-m-d H:i:s', strtotime($input['enddate'].' 23:59:59'));
                $checkin = $CheckinModel->where('pt', $this->data['uid'])->where('checked_at  <=', $enddate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('pt', $this->data['uid'])->where('checked_at  <=', $enddate)->find();
                $dispinput = [
                    'startdate' => '',
                    'enddate'   => $input['enddate']
                ];
            } else {
                $checkin = $CheckinModel->where('pt', $this->data['uid'])->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('pt', $this->data['uid'])->find();
                $dispinput = [
                    'startdate' => '',
                    'enddate'   => ''
                ];
            }
        } elseif ((!empty($input['pt'])) && ($input['pt'] != '0') && ($this->data['role'] != 'personal trainer')) {
            if (!empty($input['startdate']) && !empty($input['enddate'])) {
                $startdate = date('Y-m-d H:i:s', strtotime($input['startdate'].' 00:00:00'));
                $enddate = date('Y-m-d H:i:s', strtotime($input['enddate'].' 23:59:59'));
                $checkin = $CheckinModel->where('pt', $input['pt'])->where('checked_at >=', $startdate)->where('checked_at  <=', $enddate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('pt', $input['pt'])->where('checked_at >=', $startdate)->where('checked_at  <=', $enddate)->find();
                $dispinput = [
                    'startdate' => $input['startdate'],
                    'enddate'   => $input['enddate'],
                    'pt'        => $input['pt']
                ];
            } elseif (!empty($input['startdate']) && empty($input['enddate'])) {
                $startdate = date('Y-m-d H:i:s', strtotime($input['startdate'].' 00:00:00'));
                $checkin = $CheckinModel->where('pt', $input['pt'])->where('checked_at >=', $startdate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('pt', $input['pt'])->where('checked_at >=', $startdate)->find();
                $dispinput = [
                    'startdate' => $input['startdate'],
                    'enddate'   => '',
                    'pt'        => $input['pt']
                ];
            } elseif (empty($input['startdate']) && !empty($input['enddate'])) {
                $enddate = date('Y-m-d H:i:s', strtotime($input['enddate'].' 23:59:59'));
                $checkin = $CheckinModel->where('pt', $input['pt'])->where('checked_at  <=', $enddate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('pt', $input['pt'])->where('checked_at  <=', $enddate)->find();
                $dispinput = [
                    'startdate' => '',
                    'enddate'   => $input['enddate'],
                    'pt'        => $input['pt']
                ];
            } else {
                $checkin = $CheckinModel->where('pt', $input['pt'])->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('pt', $input['pt'])->find();
                $dispinput = [
                    'startdate' => '',
                    'enddate'   => '',
                    'pt'        => $input['pt']
                ];
            }
        } elseif ((!empty($input['pt'])) && ($input['pt'] === 'nopt') && ($this->data['role'] != 'personal trainer')) {
            if (!empty($input['startdate']) && !empty($input['enddate'])) {
                $startdate = date('Y-m-d H:i:s', strtotime($input['startdate'].' 00:00:00'));
                $enddate = date('Y-m-d H:i:s', strtotime($input['enddate'].' 23:59:59'));
                $checkin = $CheckinModel->where('checked_at >=', $startdate)->where('checked_at  <=', $enddate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('checked_at >=', $startdate)->where('checked_at  <=', $enddate)->find();
                $dispinput = [
                    'startdate' => $input['startdate'],
                    'enddate'   => $input['enddate'],
                    'pt'        => $input['pt']
                ];
            } elseif (!empty($input['startdate']) && empty($input['enddate'])) {
                $startdate = date('Y-m-d H:i:s', strtotime($input['startdate'].' 00:00:00'));
                $checkin = $CheckinModel->where('checked_at >=', $startdate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('checked_at >=', $startdate)->find();
                $dispinput = [
                    'startdate' => $input['startdate'],
                    'enddate'   => '',
                    'pt'        => $input['pt']
                ];
            } elseif (empty($input['startdate']) && !empty($input['enddate'])) {
                $enddate = date('Y-m-d H:i:s', strtotime($input['enddate'].' 23:59:59'));
                $checkin = $CheckinModel->where('checked_at  <=', $enddate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->where('checked_at  <=', $enddate)->find();
                $dispinput = [
                    'startdate' => '',
                    'enddate'   => $input['enddate'],
                    'pt'        => $input['pt']
                ];
            } else {
                $checkin = $CheckinModel->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
                $total = $CheckinModel->findAll();
                $dispinput = [
                    'startdate' => '',
                    'enddate'   => '',
                    'pt'        => $input['pt']
                ];
            }
        }

        $dispinput['sort'] = $sort;

        $data                   = $this->data;
        $data['title']          = lang('Global.checkinLog');
        $data['description']    = lang('Global.checkinLogDesc');
        $data['checkins']       = $checkin;
        $data['users']          = $UserModel->findAll();
        $data['pager']          = $CheckinModel->pager;
        $data['total']          = $total;
        $data['input']          = $dispinput;
        $data['pts']            = $pts;

        return view('checkinreport', $data);
    }
}