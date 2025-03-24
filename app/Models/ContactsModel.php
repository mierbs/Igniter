<?php

namespace App\Models;

use CodeIgniter\Model;

class ContactsModel extends Model
{
    protected $table      = 'contacts';
    protected $primaryKey = 'contact_id';
    protected $allowedFields = [
        'user_id',
        'name', 
        'company',
        'phone', 
        'email', 
        'status'

    ];

    public function insertContact($data)
    {
        $this->save($data);
    }

    public function updateContact($data,$contact_id)
    {
        $array = [
            'name'      => $data['name'],
            'company'   => $data['company'],
            'phone'     => $data['phone'],
            'email'     => $data['email'],
        ];

        $this->set($array)->where('contact_id',$contact_id)->update();
    }

    public function deleteContact($contact_id)
    {
    
        $this->set('status',0)->where('contact_id',$contact_id)->update();
    }



}