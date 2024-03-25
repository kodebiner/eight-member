<?php

namespace App\Controllers;

use App\Models\PromoModel;
use App\Models\ActivityModel;

class Promo extends BaseController
{
    public function index()
    {
        // Calling Models & Services
        $pager          = \Config\Services::pager();
        $PromoModel     = new PromoModel();

        // Parsing Data to View
        $data                   = $this->data;
        $data['title']          = lang('Global.promoList');
        $data['description']    = lang('Global.promoListDesc');
        $data['promos']         = $PromoModel->paginate(10, 'promos');
        $data['pager']          = $PromoModel->pager;
        $data['name']           = lang('Global.promoName');
        $data['create']         = lang('Global.createPromo');
        $data['createAction']   = 'promo/create';
        $data['edit']           = lang('Global.editPromo');
        $data['editAction']     = 'promo/update';
        $data['delete']         = lang('Global.deletePromo');
        $data['deleteAction']   = 'promo/delete';

        // Rendering View
        return view('promo', $data);
    }

    public function create()
    {
        // Calling Models
        $PromoModel     = new PromoModel();
        $ActivityModel  = new ActivityModel();

        // Populating Data
        $input = $this->request->getPost('name');

        // Creating Promo
        $promo = ['name' => $input];
        $PromoModel->save($promo);

        // Recording Activity
        $activity = [
            'user_id'   => $this->data['uid'],
            'activity'  => 'Adding promo '.$input,
            'done_at'   => date('Y-m-d H:i:s')
        ];
        $ActivityModel->save($activity);

        // Redirecting
        return redirect()->back()->with('message', lang('Global.promoAdded'));
    }

    public function update($id)
    {
        // Calling Models
        $PromoModel     = new PromoModel();
        $ActivityModel  = new ActivityModel();

        // Populating Data
        $input = $this->request->getPost('name');
        $promo = $PromoModel->find($id);

        // Recording Activity
        $activity = [
            'user_id'   => $this->data['uid'],
            'activity'  => 'Updating promo '.$promo['name'],
            'done_at'   => date('Y-m-d H:i:s')
        ];
        $ActivityModel->save($activity);

        // Updating Data
        $update = [
            'id'        => $id,
            'name'      => $input
        ];
        $PromoModel->save($update);

        // Redirecting
        return redirect()->back()->with('message', lang('Global.promoUpdated'));
    }

    public function delete()
    {
        // Calling Models
        $PromoModel     = new PromoModel();
        $ActivityModel  = new ActivityModel();

        // Populating Data
        $input = $this->request->getPost('promoid');
        $promo = $PromoModel->find($input);

        // Recording Activity
        $activity = [
            'user_id'   => $this->data['uid'],
            'activity'  => 'Deleting promo '.$promo['name'],
            'done_at'   => date('Y-m-d H:i:s')
        ];
        $ActivityModel->save($activity);

        // Delete Data
        $PromoModel->delete($input);

        // Redirect
        return redirect()->back()->with('error', lang('Global.promoDeleted'));
    }
}