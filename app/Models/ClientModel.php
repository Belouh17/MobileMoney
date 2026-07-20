<?php
namespace App\Models;
use CodeIgniter\Model;

class ClientModel extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $allowedFields = ['numero_telephone', 'solde', 'date_derniere_connexion', 'actif'];
    protected $useTimestamps = false;

    public function situationComptes()
    {
        return $this->orderBy('solde', 'DESC')->findAll();
    }
}