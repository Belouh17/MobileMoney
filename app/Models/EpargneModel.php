<?php
namespace App\Models;
use CodeIgniter\Model;

class EpargneModel extends Model
{
    protected $table = 'epargne';
    protected $primaryKey = 'id';
    protected $allowedFields = ['client_id', 'pourcentage', 'date_creation', 'date_modification'];
    protected $useTimestamps = false;

    public function getTauxEpargne($clientId)
    {
        $result = $this->where('client_id', $clientId)->first();
        return $result ? (float) $result['pourcentage'] : 0;
    }

    public function definirTaux($clientId, $pourcentage)
    {
        $existing = $this->where('client_id', $clientId)->first();
        if ($existing) {
            return $this->update($existing['id'], [
                'pourcentage' => $pourcentage,
                'date_modification' => date('Y-m-d H:i:s'),
            ]);
        } else {
            return $this->insert([
                'client_id' => $clientId,
                'pourcentage' => $pourcentage,
                'date_creation' => date('Y-m-d H:i:s'),
                'date_modification' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function getMontantEpargne($clientId)
    {
        $db = db_connect();
        $result = $db->table('epargne_clients')
            ->select('COALESCE(SUM(montant), 0) as total')
            ->where('client_id', $clientId)
            ->get()
            ->getRow();
        return $result ? (float) $result->total : 0;
    }
}