<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\TypeOperationModel;
use App\Models\BaremeFraisModel;
use App\Models\BeneficeModel;

class ClientController extends BaseController
{


public function login()
{
    return view('client/login');
}

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
            'numero_telephone' => $telephone,
            'solde' => 0,
        ], true);

        if ($id === false) {
            return redirect()->back()->withInput()->with('error', 'Impossible de créer le compte client.');
        }

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
public function depotForm()
    {
        $model = new ClientModel();
        $data['client'] = $model->find(session()->get('client_id'));
        return view('client/depot', $data);
    }

 public function depot()
    {
        $clientId = session()->get('client_id');
        $montant  = (float) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->to('client/depot')->with('error', 'Montant invalide.');
        }

        $typeModel = new TypeOperationModel();
        $type = $typeModel->where('code', 'DEPOT')->first();

        $db = db_connect();
        $db->transStart();

        $client = $db->table('clients')->where('id', $clientId)->get()->getRow();

        $nouveauSolde = $client->solde + $montant;

        $db->table('clients')->where('id', $clientId)->update(['solde' => $nouveauSolde]);

        $db->table('operations')->insert([
            'reference'         => uniqid('DEP-'),
            'type_operation_id' => $type['id'],
            'client_id'         => $clientId,
            'montant'           => $montant,
            'frais'             => 0,
            'solde_avant'       => $client->solde,
            'solde_apres'       => $nouveauSolde,
            'statut'            => 'REUSSI',
        ]);

        $db->transComplete();

        return redirect()->to('client/dashbord');
    }
     public function retraitForm()
    {
        $model = new ClientModel();
        $data['client'] = $model->find(session()->get('client_id'));
        return view('client/retrait', $data);
    }
    public function retrait()
    {
        $clientId = session()->get('client_id');
        $montant  = (float) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->to('client/retrait')->with('error', 'Montant invalide.');
        }

        $typeModel   = new TypeOperationModel();
        $baremeModel = new BaremeFraisModel();
        $beneficeModel = new BeneficeModel();

        $type   = $typeModel->where('code', 'RETRAIT')->first();
        $bareme = $baremeModel->getBaremeParType($type['id'], $montant);

        $frais = $bareme
            ? (float) $bareme['frais_fixe'] + $montant * ((float) $bareme['frais_pourcentage'] / 100)
            : 0;

        $db = db_connect();
        $client = $db->table('clients')->where('id', $clientId)->get()->getRow();

        $total = $montant + $frais;

        if ($total > $client->solde) {
            return redirect()->to('client/retrait')->with('error', 'Solde insuffisant.');
        }

        $db->transStart();

        $nouveauSolde = $client->solde - $total;

        $db->table('clients')->where('id', $clientId)->update(['solde' => $nouveauSolde]);

        $operationId = $db->table('operations')->insert([
            'reference'         => uniqid('RET-'),
            'type_operation_id' => $type['id'],
            'client_id'         => $clientId,
            'montant'           => $montant,
            'frais'             => $frais,
            'solde_avant'       => $client->solde,
            'solde_apres'       => $nouveauSolde,
            'statut'            => 'REUSSI',
        ]);

        if ($frais > 0) {
            $beneficeModel->insert([
                'operation_id'      => $db->insertID(),
                'type_operation_id' => $type['id'],
                'montant'           => $frais,
            ]);
        }

        $db->transComplete();

        return redirect()->to('client/dashbord');
    }
     public function transfertForm()
    {
        $model = new ClientModel();
        $data['client'] = $model->find(session()->get('client_id'));
        return view('client/transfert', $data);
    }
     public function transfert()
    {
        $clientId       = session()->get('client_id');
        $telDestinataire = $this->request->getPost('telephone_destinataire');
        $montant        = (float) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->to('client/transfert')->with('error', 'Montant invalide.');
        }

        $db = db_connect();

        $destinataire = $db->table('clients')->where('numero_telephone', $telDestinataire)->get()->getRow();

        if (!$destinataire) {
            return redirect()->to('client/transfert')->with('error', 'Destinataire introuvable.');
        }

        if ($destinataire->id == $clientId) {
            return redirect()->to('client/transfert')->with('error', 'Impossible de se transférer à soi-même.');
        }

        $typeModel     = new TypeOperationModel();
        $baremeModel   = new BaremeFraisModel();
        $beneficeModel = new BeneficeModel();

        $type   = $typeModel->where('code', 'TRANSFERT')->first();
        $bareme = $baremeModel->getBaremeParType($type['id'], $montant);

        $frais = $bareme
            ? (float) $bareme['frais_fixe'] + $montant * ((float) $bareme['frais_pourcentage'] / 100)
            : 0;

        $client = $db->table('clients')->where('id', $clientId)->get()->getRow();

        $total = $montant + $frais;

        if ($total > $client->solde) {
            return redirect()->to('client/transfert')->with('error', 'Solde insuffisant.');
        }

        $db->transStart();

        $soldeApresClient = $client->solde - $total;
        $soldeApresDest   = $destinataire->solde + $montant;

        $db->table('clients')->where('id', $clientId)->update(['solde' => $soldeApresClient]);
        $db->table('clients')->where('id', $destinataire->id)->update(['solde' => $soldeApresDest]);

        $db->table('operations')->insert([
            'reference'              => uniqid('TRF-'),
            'type_operation_id'      => $type['id'],
            'client_id'              => $clientId,
            'client_destinataire_id' => $destinataire->id,
            'montant'                => $montant,
            'frais'                  => $frais,
            'solde_avant'            => $client->solde,
            'solde_apres'            => $soldeApresClient,
            'statut'                 => 'REUSSI',
        ]);

        if ($frais > 0) {
            $beneficeModel->insert([
                'operation_id'      => $db->insertID(),
                'type_operation_id' => $type['id'],
                'montant'           => $frais,
            ]);
        }

        $db->transComplete();

        return redirect()->to('client/dashbord');
    }
    public function historique()
    {
        $clientId = session()->get('client_id');

        $db = db_connect();

        $data['operations'] = $db->table('operations')
            ->where('client_id', $clientId)
            ->orderBy('date_operation', 'DESC')
            ->get()
            ->getResult();

        return view('client/historique', $data);
    }
}