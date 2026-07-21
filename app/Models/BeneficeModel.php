<?php
namespace App\Models;
use CodeIgniter\Model;

class BeneficeModel extends Model
{
    protected $table = 'benefices';
    protected $primaryKey = 'id';
    protected $allowedFields = ['operation_id', 'type_operation_id', 'montant'];
    protected $useTimestamps = false;

    // public function situationGains()
    // {
    //     return $this->select('types_operation.libelle as type_operation, SUM(benefices.montant) as total_frais')
    //                  ->join('types_operation', 'types_operation.id = benefices.type_operation_id')
    //                  ->groupBy('types_operation.libelle')
    //                  ->findAll();
    // }

public function situationGains()
{
    $db = db_connect();
    return $db->query('SELECT * FROM vue_gains_frais')->getResultArray();
}

// public function situationGains()
// {
//     return db_connect()->query('SELECT * FROM vue_gains_frais ORDER BY reseau, type_operation')->getResultArray();
// }

    public function enregistrer(int $operationId, int $typeOperationId, float $montant): void
    {
        if ($montant > 0) {
            $this->insert([
                'operation_id' => $operationId,
                'type_operation_id' => $typeOperationId,
                'montant' => $montant,
            ]);
        }
    }

}