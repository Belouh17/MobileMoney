<?php

namespace App\Models;

use CodeIgniter\Model;

class AutreOperateurModel extends Model
{
    protected $table = 'autres_operateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom', 'commission_pourcentage', 'actif'];
    protected $useTimestamps = false;


    public function trouverParTelephone(string $telephone)
    {
        $prefixe = substr($telephone, 0, 3);
        $db = db_connect();
        $row = $db->table('autres_operateurs_prefixes')
            ->where('prefixe', $prefixe)
            ->where('actif', 1)
            ->get()->getRow();

        return $row ? $this->find($row->autre_operateur_id) : null;
    }

// public function trouverParTelephone(string $numero)
// {
//     $prefixe = substr($numero, 0, 3);
//     return $this->db->table('autres_operateurs ao')
//         ->select('ao.*')
//         ->join('autres_operateurs_prefixes p', 'p.autre_operateur_id = ao.id')
//         ->where('p.prefixe', $prefixe)
//         ->where('p.actif', 1)
//         ->where('ao.actif', 1)
//         ->get()
//         ->getRowArray();
// }

}
