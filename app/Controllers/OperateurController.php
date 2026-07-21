<?php
namespace App\Controllers;

use App\Models\PrefixeModel;
use App\Models\TypeOperationModel;
use App\Models\BaremeFraisModel;
use App\Models\BeneficeModel;
use App\Models\OperateurModel;
use App\Models\ClientModel;
use App\Models\AutreOperateurModel;
use App\Models\AutreOperateurPrefixeModel;

class OperateurController extends BaseController
{
    // ---------- PREFIXES ----------
    public function prefixes()
    {
        $model = new PrefixeModel();
        return view('operateur/prefixes', ['prefixes' => $model->findAll()]);
    }

    // public function ajouterPrefixe()
    // {
    //     $model = new PrefixeModel();
    //     $model->insert([
    //         'prefixe' => $this->request->getPost('prefixe'),
    //         'actif'   => 1,
    //     ]);
    //     return redirect()->to('/operateur/prefixes');
    // }

    public function ajouterPrefixe()
{
    $model = new PrefixeModel();
    try {
        $model->insert([
            'prefixe' => $this->request->getPost('prefixe'),
            'actif'   => 1,
        ]);
    } catch (\Throwable $e) {
        return redirect()->to('/operateur/prefixes')->with('erreur', 'Ce préfixe existe déjà.');
    }
    return redirect()->to('/operateur/prefixes');
}

    public function supprimerPrefixe($id)
    {
        (new PrefixeModel())->delete($id);
        return redirect()->to('/operateur/prefixes');
    }

    // ---------- TYPES D'OPERATIONS ----------
    public function types()
    {
        $model = new TypeOperationModel();
        return view('operateur/types', ['types' => $model->findAll()]);
    }

    public function ajouterType()
    {
        $model = new TypeOperationModel();
        $model->insert([
            'code'    => $this->request->getPost('code'),
            'libelle' => $this->request->getPost('libelle'),
            'actif'   => 1,
        ]);
        return redirect()->to('/operateur/types');
    }

    // ---------- BAREMES DE FRAIS ----------
    public function baremes($typeOperationId)
    {
        $baremeModel = new BaremeFraisModel();
        $typeModel   = new TypeOperationModel();

        return view('operateur/baremes', [
            'baremes' => $baremeModel->where('type_operation_id', $typeOperationId)->findAll(),
            'type'    => $typeModel->find($typeOperationId),
        ]);
    }

    public function ajouterBareme()
    {
        $model = new BaremeFraisModel();
        $model->insert([
            'type_operation_id' => $this->request->getPost('type_operation_id'),
            'montant_min'       => $this->request->getPost('montant_min'),
            'montant_max'       => $this->request->getPost('montant_max') ?: null,
            'frais_fixe'        => $this->request->getPost('frais_fixe'),
            'frais_pourcentage' => $this->request->getPost('frais_pourcentage') ?: 0,
            'actif'             => 1,
            'date_modification' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->back();
    }

    public function modifierBareme($id)
    {
        $model = new BaremeFraisModel();
        $model->update($id, [
            'montant_min'       => $this->request->getPost('montant_min'),
            'montant_max'       => $this->request->getPost('montant_max') ?: null,
            'frais_fixe'        => $this->request->getPost('frais_fixe'),
            'frais_pourcentage' => $this->request->getPost('frais_pourcentage') ?: 0,
            'date_modification' => date('Y-m-d H:i:s'),
        ]);
        return redirect()->back();
    }

    public function supprimerBareme($id)
    {
        (new BaremeFraisModel())->delete($id);
        return redirect()->back();
    }

    // ---------- RAPPORTS ----------
    public function gains()
    {
        $model = new BeneficeModel();
        return view('operateur/gains', ['gains' => $model->situationGains()]);
    }

    public function comptes()
    {
        $model = new ClientModel();
        return view('operateur/comptes', ['clients' => $model->situationComptes()]);
    }


// ---------- Connexion ----------
public function login()
{
    return view('operateur/login');
}

// public function auth()
// {
//     $model = new OperateurModel();

//     $nomUtilisateur = trim($this->request->getPost('username'));
//     $motDePasse = $this->request->getPost('password');

//     $operateur = $model->where('nom_utilisateur', $nomUtilisateur)
//                         ->where('actif', 1)
//                         ->first();

//     if (!$operateur || !password_verify($motDePasse, $operateur['mot_de_passe'])) {
//         return redirect()->to('/operateur/login')->with('erreur', 'Identifiants incorrects.');
//     }

//     $model->update($operateur['id'], ['date_derniere_connexion' => date('Y-m-d H:i:s')]);

//     session()->set([
//         'operateur_id' => $operateur['id'],
//         'operateur_nom' => $operateur['nom_utilisateur'],
//     ]);

//     return redirect()->to('/operateur/prefixes');
// }

public function auth()
{
    $model = new OperateurModel();

    $nomUtilisateur = trim($this->request->getPost('username'));
    $motDePasse = $this->request->getPost('password');

    $operateur = $model->where('nom_utilisateur', $nomUtilisateur)
                        ->where('actif', 1)
                        ->first();

    if (!$operateur || !password_verify($motDePasse, $operateur['mot_de_passe'])) {
        return redirect()->to('/operateur/login')->with('erreur', 'Identifiants incorrects.');
    }

    $model->update($operateur['id'], ['date_derniere_connexion' => date('Y-m-d H:i:s')]);

    session()->set([
        'operateur_id' => $operateur['id'],
        'operateur_nom' => $operateur['nom_utilisateur'],
    ]);

    return redirect()->to('/operateur/dashboard'); // <-- au lieu de /operateur/prefixes
}

public function logout()
{
    session()->remove(['operateur_id', 'operateur_nom']);
    return redirect()->to('/operateur/login');
}

public function autresOperateurs()
{
    $model = new AutreOperateurModel();
    return view('operateur/autres_operateurs', ['operateurs' => $model->findAll()]);
}

public function ajouterAutreOperateur()
{
    $model = new AutreOperateurModel();
    $model->insert([
        'nom' => $this->request->getPost('nom'),
        'commission_pourcentage' => $this->request->getPost('commission_pourcentage') ?: 0,
        'actif' => 1,
    ]);
    return redirect()->to('/operateur/autres-operateurs');
}

public function modifierAutreOperateur($id)
{
    (new AutreOperateurModel())->update($id, [
        'commission_pourcentage' => $this->request->getPost('commission_pourcentage'),
    ]);
    return redirect()->to('/operateur/autres-operateurs');
}

public function prefixesAutreOperateur($autreOperateurId)
{
    $prefixeModel = new AutreOperateurPrefixeModel();
    $operateurModel = new AutreOperateurModel();

    return view('operateur/autres_operateurs_prefixes', [
        'prefixes' => $prefixeModel->where('autre_operateur_id', $autreOperateurId)->findAll(),
        'operateur' => $operateurModel->find($autreOperateurId),
    ]);
}

public function ajouterPrefixeAutreOperateur()
{
    (new AutreOperateurPrefixeModel())->insert([
        'autre_operateur_id' => $this->request->getPost('autre_operateur_id'),
        'prefixe' => $this->request->getPost('prefixe'),
        'actif' => 1,
    ]);
    return redirect()->back();
}

public function supprimerPrefixeAutreOperateur($id)
{
    (new AutreOperateurPrefixeModel())->delete($id);
    return redirect()->back();
}

public function montantsAEnvoyer()
{
    $db = db_connect();
    $data = $db->query('SELECT * FROM vue_montants_a_envoyer')->getResultArray();
    return view('operateur/montants_a_envoyer', ['montants' => $data]);
}

public function dashboard()
{
    return view('operateur/dashboard');
}

}