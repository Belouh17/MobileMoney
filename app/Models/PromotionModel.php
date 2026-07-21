<?php
namespace App\Models;
use CodeIgniter\Model;

class PromotionModel extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['promo_pourcentage'];
    protected $useTimestamps = false;

    public function getPromo()
    {
        $db = db_connect();
        $result = $db->query('SELECT * FROM promotions WHERE id = 1')->getRowArray();
        return $result ? (float) $result['promo_pourcentage'] : 0;
    }

    public function setPromo($pourcentage)
    {
        $db = db_connect();
        $exists = $db->query('SELECT id FROM promotions WHERE id = 1')->getRowArray();
        if ($exists) {
            $db->query('UPDATE promotions SET promo_pourcentage = ? WHERE id = 1', [$pourcentage]);
        } else {
            $db->query('INSERT INTO promotions (id, promo_pourcentage) VALUES (1, ?)', [$pourcentage]);
        }
    }
}