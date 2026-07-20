namespace App\Models;

use CodeIgniter\Model;

class EmpruntModel extends Model
{
    protected $table = 'emprunts';

    protected $allowedFields = [
        'livre_id','emprunteur','date_emprunt','date_retour'
    ];

    public function lastEmprunt($livre_id)
    {
        return $this->where('livre_id', $livre_id)
                    ->orderBy('date_emprunt', 'DESC')
                    ->first();
    }
}