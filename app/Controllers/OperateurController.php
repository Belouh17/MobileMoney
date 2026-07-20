<?php
namespace App\Controllers;

use App\Models\PrefixeModel;
use App\Models\TypeOperationModel;
use App\Models\BaremeFraisModel;
use App\Models\BeneficeModel;
use App\Models\ClientModel;

class OperateurController extends BaseController
{
    // ---------- PREFIXES ----------
    public function prefixes()
    {
        $model = new PrefixeModel();
        return view('operateur/prefixes', ['prefixes' => $model->findAll()]);
    }

    public function ajouterPrefixe()
    {
        $model = new PrefixeModel();
        $model->insert([
            'prefixe' => $this->request->getPost('prefixe'),
            'actif'   => 1,
        ]);
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
}