<?php

namespace App\Controllers;

use App\Models\ClientModel;
use App\Models\TypeOperationModel;
use App\Models\BaremeFraisModel;
use App\Models\BeneficeModel;
use App\Models\AutreOperateurModel;
use App\Models\EpargneModel;
use App\Models\PromotionModel;

class ClientController extends BaseController
{

    private const PROMO_INTERNE = 1 ;

    public function login()
    {
        return view('client/login', ['title' => 'Connexion client']);
    }

    private function clientConnecte()
    {
        $id = session()->get('client_id');
        return $id ? (new ClientModel())->find($id) : null;
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



        if (!$client) {

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
            'client_id' => $client['id'],
            'telephone' => $telephone
        ]);


        return redirect()
            ->to('client/dashbord');
    }
    public function dashbord()
    {
        $id = session()->get('client_id');
        $model = new ClientModel();
        $client = $model->find($id);

        return view('client/dashbord', [
            'title' => 'Tableau de bord',
            'activeMenu' => 'dashbord',
            'client' => $client,
        ]);
    }
    public function depotForm()
    {
        $model = new ClientModel();
        $epargneModel = new EpargneModel();
        $client = $model->find(session()->get('client_id'));
        $tauxEpargne = $epargneModel->getTauxEpargne($client['id']);
        $montantEpargne = $epargneModel->getMontantEpargne($client['id']);
        return view('client/depot', [
            'title' => 'Dépôt',
            'activeMenu' => 'depot',
            'client' => $client,
            'tauxEpargne' => $tauxEpargne,
            'montantEpargne' => $montantEpargne,
        ]);
    }

    public function depot()
    {
        $clientId = session()->get('client_id');
        $montant  = (float) $this->request->getPost('montant');

        if ($montant <= 0) {
            return redirect()->to('client/depot')->with('error', 'Montant invalide.');
        }

        // Récupérer le taux d'épargne du client
        $epargneModel = new EpargneModel();
        $tauxEpargne = $epargneModel->getTauxEpargne($clientId);
        $montantEpargneCalcule = $montant * ($tauxEpargne / 100);
        $montantDisponible = $montant - $montantEpargneCalcule;

        $typeModel = new TypeOperationModel();
        $type = $typeModel->where('code', 'DEPOT')->first();

        $db = db_connect();
        $db->transStart();

        $client = $db->table('clients')->where('id', $clientId)->get()->getRow();

        $nouveauSolde = $client->solde + $montantDisponible;

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

        // Enregistrer l'épargne sur le dépôt
        if ($montantEpargneCalcule > 0) {
            $db->table('epargne_clients')->insert([
                'client_id' => $clientId,
                'montant' => $montantEpargneCalcule,
                'date_creation' => date('Y-m-d H:i:s'),
                'date_modification' => date('Y-m-d H:i:s'),
            ]);
        }

        $db->transComplete();

        return redirect()->to('client/dashbord');
    }
    public function retraitForm()
    {
        $model = new ClientModel();
        $client = $model->find(session()->get('client_id'));
        return view('client/retrait', [
            'title' => 'Retrait',
            'activeMenu' => 'retrait',
            'client' => $client,
        ]);
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
        $modelepargne = new EpargneModel();
        $promotionModel = new PromotionModel();
        $client = $model->find(session()->get('client_id'));
        $tauxEpargne = $modelepargne->getTauxEpargne($client['id']);
        $montantEpargne = $modelepargne->getMontantEpargne($client['id']);
        $promo = $promotionModel->getPromo();
        return view('client/transfert', [
            'title' => 'Transfert',
            'activeMenu' => 'transfert',
            'client' => $client,
            'tauxEpargne' => $tauxEpargne,
            'montantEpargne' => $montantEpargne,
            'promo' => $promo,
        ]);
    }

    public function epargne(){
        $client = $this->clientConnecte();
        if (!$client) return redirect()->to('/client/login');

        $epargneModel = new EpargneModel();
        $tauxEpargne = $epargneModel->getTauxEpargne($client['id']);
        $montantEpargne = $epargneModel->getMontantEpargne($client['id']);

        return view('client/epargne', [
            'title' => 'Épargne',
            'activeMenu' => 'epargne',
            'client' => $client,
            'tauxEpargne' => $tauxEpargne,
            'montantEpargne' => $montantEpargne,
        ]);
    }

    public function definirEpargne()
    {
        $client = $this->clientConnecte();
        if (!$client) return redirect()->to('/client/login');

        $pourcentage = (float) $this->request->getPost('pourcentage');
        if ($pourcentage < 0 || $pourcentage > 100) {
            return redirect()->to('client/epargne')->with('error', 'Le pourcentage doit être entre 0 et 100.');
        }

        $epargneModel = new EpargneModel();
        $epargneModel->definirTaux($client['id'], $pourcentage);

        return redirect()->to('client/epargne')->with('succes', 'Taux d\'épargne mis à jour.');
    }

    public function transfert()
    {
        $client = $this->clientConnecte();
        if (!$client) return redirect()->to('/client/login');

        $telDest = trim($this->request->getPost('telephone_destinataire'));
        $montant = (float) $this->request->getPost('montant');
        $optionFraisRetrait = $this->request->getPost('option_frais_retrait');
        if ($montant <= 0) {
            return redirect()->to('client/transfert')->with('error', 'Montant invalide.');
        }

        $clientModel = new ClientModel();
        $destinataire = $clientModel->where('numero_telephone', $telDest)->first();

        $typeModel = new TypeOperationModel();
        $baremeModel = new BaremeFraisModel();
        $beneficeModel = new BeneficeModel();
        $type = $typeModel->where('code', 'TRANSFERT')->first();
        $bareme = $baremeModel->getBaremeParType($type['id'], $montant);
        $fraisTransfert = $bareme ? (float) $bareme['frais_fixe'] + $montant * ((float) $bareme['frais_pourcentage'] / 100) : 0;

        $db = db_connect();

        if ($destinataire) {
            // ---------- Transfert interne (notre réseau) ----------
            $fraisRetraitAnticipe = 0;
            if ($optionFraisRetrait === 'AVEC_FRAIS_RETRAIT') {
                $typeRetrait = $typeModel->where('code', 'RETRAIT')->first();
                $baremeRetrait = $baremeModel->getBaremeParType($typeRetrait['id'], $montant);
                $fraisRetraitAnticipe = $baremeRetrait ? (float) $baremeRetrait['frais_fixe'] : 0;
            }

            $promoInterne = $fraisTransfert * (self::PROMO_INTERNE / 100);

            $total = $montant + $fraisTransfert + $fraisRetraitAnticipe - $promoInterne;
            if ($total > $client['solde']) {
                return redirect()->to('client/transfert')->with('error', 'Solde insuffisant.');
            }

            $db->transStart();
            $soldeApresClient = $client['solde'] - $total;
            $soldeApresDest = $destinataire['solde'] + $montant + $fraisRetraitAnticipe;

            $db->table('clients')->where('id', $client['id'])->update(['solde' => $soldeApresClient]);
            $db->table('clients')->where('id', $destinataire['id'])->update(['solde' => $soldeApresDest]);

            $db->table('operations')->insert([
                'reference' => uniqid('TRF-'),
                'type_operation_id' => $type['id'],
                'client_id' => $client['id'],
                'client_destinataire_id' => $destinataire['id'],
                'montant' => $montant,
                'frais' => $fraisTransfert + $fraisRetraitAnticipe,
                'solde_avant' => $client['solde'],
                'solde_apres' => $soldeApresClient,
                'statut' => 'REUSSI',
            ]);
            $opId = $db->insertID();

            if ($fraisTransfert > 0) {
                if ($promoInterne > 0) {
                    $beneficeModel->insert(['operation_id' => $opId, 'type_operation_id' => $type['id'], 'montant' =>$fraisTransfert-$promoInterne]);
                }
                else{
                $beneficeModel->insert(['operation_id' => $opId, 'type_operation_id' => $type['id'], 'montant' => $fraisTransfert]);
                }
            }
            if ($promoInterne > 0) {
                $beneficeModel->insert(['operation_id' => $opId, 'type_operation_id' => $type['id'], 'montant' => $promoInterne]);
            }
            if ($fraisRetraitAnticipe > 0) {
                $typeRetrait = $typeModel->where('code', 'RETRAIT')->first();
                $beneficeModel->insert(['operation_id' => $opId, 'type_operation_id' => $typeRetrait['id'], 'montant' => $fraisRetraitAnticipe]);
            }

            $db->transComplete();
            return redirect()->to('client/dashbord');
        }

        // ---------- Transfert vers un autre opérateur ----------
        $autreOperateurModel = new AutreOperateurModel();
        $autreOperateur = $autreOperateurModel->trouverParTelephone($telDest);

        if (!$autreOperateur) {
            return redirect()->to('client/transfert')->with('error', 'Numéro non reconnu.');
        }

        // pas de frais de retrait anticipé possible ici
        $commission = $montant * ((float) $autreOperateur['commission_pourcentage'] / 100);
        $fraisTotal = $fraisTransfert + $commission;
        $total = $montant + $fraisTotal;

        if ($total > $client['solde']) {
            return redirect()->to('client/transfert')->with('error', 'Solde insuffisant.');
        }

        $db->transStart();
        $soldeApresClient = $client['solde'] - $total;
        $db->table('clients')->where('id', $client['id'])->update(['solde' => $soldeApresClient]);

        $db->table('operations')->insert([
            'reference' => uniqid('TRF-EXT-'),
            'type_operation_id' => $type['id'],
            'client_id' => $client['id'],
            'autre_operateur_id' => $autreOperateur['id'],
            'montant' => $montant,
            'frais' => $fraisTotal,
            'solde_avant' => $client['solde'],
            'solde_apres' => $soldeApresClient,
            'statut' => 'REUSSI',
        ]);
        $opId = $db->insertID();

        if ($fraisTotal > 0) {
            $beneficeModel->insert(['operation_id' => $opId, 'type_operation_id' => $type['id'], 'montant' => $fraisTotal]);
        }

        $db->transComplete();
        return redirect()->to('client/dashbord');
    }
    public function historique()
    {
        $clientId = session()->get('client_id');
        $db = db_connect();
        $operations = $db->table('operations')
            ->where('client_id', $clientId)
            ->orderBy('date_operation', 'DESC')
            ->get()
            ->getResult();

        return view('client/historique', [
            'title' => 'Historique',
            'activeMenu' => 'historique',
            'operations' => $operations,
        ]);
    }

    public function transfertMultipleForm()
    {
        $client = $this->clientConnecte();
        if (!$client) return redirect()->to('/client/login');
        return view('client/transfert_multiple', [
            'title' => 'Envoi multiple',
            'activeMenu' => 'transfertMultiple',
            'client' => $client,
        ]);
    }

    public function transfertMultiple()
    {
        $client = $this->clientConnecte();
        if (!$client) return redirect()->to('/client/login');

        $numeros = array_filter(array_map('trim', explode(',', $this->request->getPost('numeros'))));
        $montantTotal = (float) $this->request->getPost('montant_total');

        $nb = count($numeros);
        if ($nb < 2 || $montantTotal <= 0) {
            return redirect()->to('client/transfert-multiple')->with('error', 'Il faut au moins 2 numéros et un montant valide.');
        }

        $montantParDest = round($montantTotal / $nb, 2);

        $clientModel = new ClientModel();
        $typeModel = new TypeOperationModel();
        $baremeModel = new BaremeFraisModel();
        $beneficeModel = new BeneficeModel();
        $type = $typeModel->where('code', 'TRANSFERT')->first();

        // vérifier que tous les numéros sont sur notre réseau
        $destinataires = [];
        foreach ($numeros as $num) {
            $dest = $clientModel->where('numero_telephone', $num)->first();
            if (!$dest) {
                return redirect()->to('client/transfert-multiple')->with('error', "Le numéro $num n'est pas sur notre réseau.");
            }
            $destinataires[] = $dest;
        }

        $bareme = $baremeModel->getBaremeParType($type['id'], $montantParDest);
        $fraisParEnvoi = $bareme ? (float) $bareme['frais_fixe'] + $montantParDest * ((float) $bareme['frais_pourcentage'] / 100) : 0;
        $totalDebit = ($montantParDest + $fraisParEnvoi) * $nb;

        if ($totalDebit > $client['solde']) {
            return redirect()->to('client/transfert-multiple')->with('error', 'Solde insuffisant pour cet envoi groupé.');
        }

        $db = db_connect();
        $db->transStart();

        $referenceLot = uniqid('LOT-');
        $soldeCourant = $client['solde'];

        foreach ($destinataires as $dest) {
            $soldeAvant = $soldeCourant;
            $soldeCourant -= ($montantParDest + $fraisParEnvoi);

            $db->table('clients')->where('id', $client['id'])->update(['solde' => $soldeCourant]);
            $db->table('clients')->where('id', $dest['id'])->update(['solde' => $dest['solde'] + $montantParDest]);

            $db->table('operations')->insert([
                'reference' => uniqid('TRF-'),
                'reference_lot' => $referenceLot,
                'type_operation_id' => $type['id'],
                'client_id' => $client['id'],
                'client_destinataire_id' => $dest['id'],
                'montant' => $montantParDest,
                'frais' => $fraisParEnvoi,
                'solde_avant' => $soldeAvant,
                'solde_apres' => $soldeCourant,
                'statut' => 'REUSSI',
            ]);

            if ($fraisParEnvoi > 0) {
                $beneficeModel->insert(['operation_id' => $db->insertID(), 'type_operation_id' => $type['id'], 'montant' => $fraisParEnvoi]);
            }
        }

        $db->transComplete();
        return redirect()->to('client/dashbord');
    }
    public function logout()
    {
        session()->remove(['client_id', 'telephone']);
        return redirect()->to('/client/login');
    }
}
