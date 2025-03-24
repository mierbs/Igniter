<?php

namespace App\Controllers;
use App\Models\ContactsModel;

class ContactsController extends BaseController
{
    //Contact Page
    public function contacts()
    {
        session();
        if (!isset($_SESSION['name'])) {
           
            return redirect('signin');
        }
            $userid = session()->get('user_id');
            $model = model(ContactsModel::class);

            $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
            $per_page = 5;

            $data['data'] = $model->where([
                'user_id' => $userid,
                'status'  => 1
            ])->paginate($per_page,'default',$page);
            $data['pager'] = $model->pager;
            $data['total_items'] = $model->where('user_id',$userid)->countAllResults();
            $data['title']= 'Contacts';
            $data['main_content'] = 'contactsView.php';

            return view ('innerpages/template', $data);
            
    }

    //Add Contact Method
    public function add_contacts()
    {
        $userid = session()->get('user_id');
        $model = model(ContactsModel::class);
        $data = [
            'user_id'   => $userid,
            'name'      => $this->request->getVar('name'),
            'company'   => $this->request->getVar('company'),
            'phone'     => $this->request->getVar('phone'),
            'email'     => $this->request->getVar('email')
        ];
        $model->insertContact($data);
        return redirect('contacts');
    }

    //Edit Contact Method
    public function edit_contacts()
    {
        $model = model(ContactsModel::class);
        $contact_id = $this->request->getVar('contact_id');
        $data = [
            'name'      => $this->request->getVar('name'),
            'company'   => $this->request->getVar('company'),
            'phone'     => $this->request->getVar('phone'),
            'email'     => $this->request->getVar('email')
        ];
        $model->updateContact($data,$contact_id);
        //echo(string)$model->getLastQuery();
        return redirect('contacts');
    }

    //Delete Contact Method
    public function delete_contact()
    {
        $model = model(ContactsModel::class);
        $contact_id = $this->request->getPost('contact_id');
        $model->deleteContact($contact_id);
        //echo $contact_id;
    }
    
    //Search Contact Method
    public function search_contacts()
    {
        helper(['form']);
        $userid = session()->get('user_id');
        $result_html = '';
        session()->set('search', $this->request->getPost('search'));
        $search = session()->get('search');
       
        $model = model(ContactsModel::class);
        $data['data'] = $model->where([
                            'user_id' => $userid,
                            'status'  => 1
                        ])
                        ->groupStart()
                            ->like('name',$search)
                            ->orlike('company',$search)
                            ->orlike('email',$search)
                            ->orlike('phone',$search)
                        ->groupEnd()
                        ->paginate(5);
        //echo(string)$model->getLastQuery();
        $data['pager'] = $model->pager;
        $i=0;

        foreach($data['data'] as $contacts) {
            $i++;
            $result_html .= '
                <tr>
                    <td>' . $i . '</td>
                    <td style="display: none">' . $contacts['contact_id']. '</td>
                    <td>' . $contacts['name'] . '</td>
                    <td>' . $contacts['company'] . '</td>
                    <td>' . $contacts['phone'] . '</td>
                    <td>' . $contacts['email'] . '</td>
                    <td> <span><a href="#" class="text-warning edit-modal-button" data-bs-toggle="modal" data-bs-target="#modal"
                                contact-id="'.$contacts['contact_id'].'"> Edit </a></span>
                         &nbsp;<span>|</span>&nbsp;
                         <span><a href="#" class="text-danger del-contact"> Delete</a></span>
                    </td>
                </tr>';                   
    
        }
        
        echo json_encode($result_html);
    }

}