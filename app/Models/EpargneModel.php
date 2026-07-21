<?php

namespace App\Models;
use CodeIgniter\Model;

class EpargneModel extends Model {
    protected $table ='epargne';
    protected $primaryKey = 'id';

    protected $allowedFields = ['client_id' , 'pourcentage' , 'date_creation' , 'date_modification'];
   protected $useTimestamps = false;
}
