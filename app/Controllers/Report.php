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

        if (isset($input['sort'])) {
            $sort = $input['sort'];
        } else {
            $sort = 10;
        }

        if (!empty($input['startdate']) && !empty($input['enddate'])) {
            $startdate = date('Y-m-d H:i:s', strtotime($input['startdate'].' 00:00:00'));
            $enddate = date('Y-m-d H:i:s', strtotime($input['enddate'].' 23:59:59'));
            $checkin = $CheckinModel->where('checked_at >=', $startdate)->where('checked_at  <=', $enddate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
            $total = $CheckinModel->where('checked_at >=', $startdate)->where('checked_at  <=', $enddate)->find();
            $dispinput = [
                'startdate' => $input['startdate'],
                'enddate'   => $input['enddate']
            ];
        } elseif (!empty($input['startdate']) && empty($input['enddate'])) {
            $startdate = date('Y-m-d H:i:s', strtotime($input['startdate'].' 00:00:00'));
            $checkin = $CheckinModel->where('checked_at >=', $startdate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
            $total = $CheckinModel->where('checked_at >=', $startdate)->find();
            $dispinput = [
                'startdate' => $input['startdate'],
                'enddate'   => ''
            ];
        } elseif (empty($input['startdate']) && !empty($input['enddate'])) {
            $enddate = date('Y-m-d H:i:s', strtotime($input['enddate'].' 23:59:59'));
            $checkin = $CheckinModel->where('checked_at  <=', $enddate)->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
            $total = $CheckinModel->where('checked_at  <=', $enddate)->find();
            $dispinput = [
                'startdate' => '',
                'enddate'   => $input['enddate']
            ];
        } else {
            $checkin = $CheckinModel->orderBy('checked_at', 'ASC')->paginate($sort, 'checkin');
            $total = $CheckinModel->findAll();
            $dispinput = [
                'startdate' => '',
                'enddate'   => ''
            ];
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

        return view('checkinreport', $data);
    }
}