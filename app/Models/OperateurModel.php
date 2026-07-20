<?php
namespace App\Models;
use CodeIgniter\Model;

class OperateurModel extends Model
{
    protected $table = 'operateurs';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nom_utilisateur', 'mot_de_passe', 'actif', 'date_derniere_connexion'];
    protected $useTimestamps = false;
}