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
        'frais_transfert',
        'frais_retrait_anticipe',
        'option_transfert',
        'solde_avant',
        'solde_apres',
        'statut'
    ];
}