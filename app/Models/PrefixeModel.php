<?php
namespace App\Models;
use CodeIgniter\Model;

class PrefixeModel extends Model
{
    protected $table = 'prefixes_operateur';
    protected $primaryKey = 'id';
    protected $allowedFields = ['prefixe', 'actif'];
    protected $useTimestamps = false;
}