<?php
namespace App\Models;
use CodeIgniter\Model;

class AutreOperateurPrefixeModel extends Model
{
    protected $table = 'autres_operateurs_prefixes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['autre_operateur_id', 'prefixe', 'actif'];
    protected $useTimestamps = false;
}