namespace App\Models;

use CodeIgniter\Model;

class LivreModel extends Model
{
    protected $table = 'livres';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'titre','auteur','isbn','annee','categorie','resume','couverture','statut'
    ];

    protected $useTimestamps = true;

    protected $validationRules = [
        'titre' => 'required|min_length[3]',
        'auteur' => 'required',
        'isbn' => 'required|is_unique[livres.isbn]',
        'annee' => 'required|integer'
    ];

    protected $validationMessages = [
        'titre' => [
            'required' => 'Titre obligatoire',
            'min_length' => 'Minimum 3 caractères'
        ],
        'auteur' => [
            'required' => 'Auteur obligatoire'
        ],
        'isbn' => [
            'required' => 'ISBN obligatoire',
            'is_unique' => 'ISBN déjà utilisé'
        ],
        'annee' => [
            'required' => 'Année obligatoire'
        ]
    ];

    // règle métier
    public function anneeValide($annee)
    {
        return $annee <= date('Y');
    }

    // recherche
    public function search($keyword = null, $categorie = null)
    {
        $builder = $this->builder();

        if ($keyword) {
            $builder->like('titre', $keyword);
        }

        if ($categorie) {
            $builder->where('categorie', $categorie);
        }

        return $builder->get()->getResult();
    }

    public function paginateLivres()
    {
        return $this->paginate(10);
    }
}