<?php
namespace App\Models;
use CodeIgniter\Model;

class PromotionModel extends Model
{
    protected $primaryKey = 'id';
    protected $promo = 'promo_pourcentage';

    public function getPromo()
{
    $db = db_connect();
    return $db->query('SELECT  FROM promotions WHERE id=1 ')->getResultArray();
}


}