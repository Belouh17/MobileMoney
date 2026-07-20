<?php
namespace App\Models;
use CodeIgniter\Model;

class BaremeFraisModel extends Model
{
    protected $table = 'baremes_frais';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'type_operation_id', 'montant_min', 'montant_max',
        'frais_fixe', 'frais_pourcentage', 'actif', 'date_modification'
    ];
    protected $useTimestamps = false;


    public function getBaremeParType(int $typeOperationId, float $montant)
    {
        return $this->where('type_operation_id', $typeOperationId)
                     ->where('actif', 1)
                     ->where('montant_min <=', $montant)
                     ->groupStart()
                        ->where('montant_max >=', $montant)
                        ->orWhere('montant_max', null)
                     ->groupEnd()
                     ->first();
    }
}