<?php

namespace App\Models;

use CodeIgniter\Model;

class OperationModel extends Model
{
    protected $table = 'operations';

    protected $primaryKey = 'id';

    protected $allowedFields = [
        'reference',
        'type_operation_id',
        'client_id',
        'client_destinataire_id',
        'montant',
        'frais',
        'solde_avant',
        'solde_apres',
        'statut'
    ];
}