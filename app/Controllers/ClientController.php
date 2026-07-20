<?php

namespace App\Controllers;

use App\Models\ClientModel;

class ClientController extends BaseController
{


public function login()
{
    return view('client/login');
}

// public function auth()
// {
//     echo WRITEPATH . 'database/database.sqlite';
//     exit;
// }

public function auth()
{

    $model = new ClientModel();


    $telephone = trim((string) $this->request->getPost('telephone'));
    if ($telephone === '') {
        return redirect()->back()->withInput()->with('error', 'Numéro de téléphone requis.');
    }

    $client = $model
              ->where(
                  'numero_telephone',
                  $telephone
            )
            ->first();



    if(!$client)
    {

        // création automatique
        $id = $model->insert([
            'numero_telephone'=>$telephone,
            'solde'=>0
        ]);


        $client = $model->find($id);

    }



    session()->set([
        'client_id'=>$client['id'],
        'telephone'=>$telephone
        ]);


    return redirect()
           ->to('client/dashbord');

}
public function dashbord()
{

    $id=session()->get('client_id');


    $model=new ClientModel();


    $data['client']=$model->find($id);


    return view(
    'client/dashbord',
    $data
    );
}
public function depot()
{

    $clientId=session()
        ->get('client_id');


    $montant=$this->request
        ->getPost('montant');


    $db=db_connect();


    $db->transStart();


    $client=$db
        ->table('clients')
        ->where('id',$clientId)
        ->get()
        ->getRow();



        $nouveauSolde=
        $client->solde+$montant;



    $db->table('clients')
    ->where('id',$clientId)
    ->update([
    'solde'=>$nouveauSolde
        ]);



    $db->table('operations')
        ->insert([

    'reference'=>uniqid(),

    'type_operation_id'=>1,

    'client_id'=>$clientId,

    'montant'=>$montant,

    'solde_avant'=>$client->solde,

    'solde_apres'=>$nouveauSolde

    ]);


    $db->transComplete();



    return redirect()
    ->to('client/dashbord');
    }
}