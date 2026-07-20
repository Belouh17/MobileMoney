PRAGMA foreign_keys = ON;

-- ============================================
-- Préfixes valides de l'opérateur
-- ============================================
CREATE TABLE prefixes_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe VARCHAR(3) NOT NULL UNIQUE,
    actif TINYINT NOT NULL DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Types d'opérations
-- ============================================
CREATE TABLE types_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code VARCHAR(20) NOT NULL UNIQUE,          -- DEPOT, RETRAIT, TRANSFERT
    libelle VARCHAR(50) NOT NULL,
    actif TINYINT NOT NULL DEFAULT 1
);

-- ============================================
-- Barèmes de frais par tranche
-- Chaque type d'opération a son propre jeu de tranches
-- (le lien se fait via type_operation_id)
-- ============================================
CREATE TABLE baremes_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    montant_min DECIMAL(15,2) NOT NULL,
    montant_max DECIMAL(15,2),                 -- NULL = pas de plafond
    frais_fixe DECIMAL(15,2) NOT NULL DEFAULT 0,
    frais_pourcentage DECIMAL(5,2) NOT NULL DEFAULT 0,
    actif TINYINT NOT NULL DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (type_operation_id) REFERENCES types_operation(id) ON DELETE CASCADE
);

CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_utilisateur VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,   -- toujours hashé (password_hash en PHP)
    actif TINYINT NOT NULL DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Clients
-- ============================================
CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_telephone VARCHAR(15) NOT NULL UNIQUE,
    solde DECIMAL(15,2) NOT NULL DEFAULT 0,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_derniere_connexion DATETIME,
    actif TINYINT NOT NULL DEFAULT 1
);

-- ============================================
-- Opérations (historique)
-- Colonnes frais_transfert / frais_retrait_anticipe / option_transfert
-- ne servent que pour les opérations de type TRANSFERT
-- ============================================
CREATE TABLE operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    reference VARCHAR(30) NOT NULL UNIQUE,
    type_operation_id INTEGER NOT NULL,
    client_id INTEGER NOT NULL,
    client_destinataire_id INTEGER,                    -- rempli uniquement pour un transfert
    montant DECIMAL(15,2) NOT NULL,
    frais DECIMAL(15,2) NOT NULL DEFAULT 0,             -- total prélevé au client (tous types confondus)
    frais_transfert DECIMAL(15,2) NOT NULL DEFAULT 0,   -- part frais transfert (si TRANSFERT)
    frais_retrait_anticipe DECIMAL(15,2) NOT NULL DEFAULT 0, -- part frais retrait payée d'avance (si TRANSFERT, option "avec frais de retrait")
    option_transfert VARCHAR(25),                       -- 'AVEC_FRAIS_RETRAIT' / 'SANS_FRAIS_RETRAIT' / NULL si non applicable
    solde_avant DECIMAL(15,2) NOT NULL,
    solde_apres DECIMAL(15,2) NOT NULL,
    date_operation DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(15) NOT NULL DEFAULT 'REUSSI',
    FOREIGN KEY (type_operation_id) REFERENCES types_operation(id) ON DELETE CASCADE,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (client_destinataire_id) REFERENCES clients(id) ON DELETE SET NULL
);



CREATE INDEX idx_operations_client ON operations(client_id);
CREATE INDEX idx_operations_date ON operations(date_operation);

-- ============================================
-- Bénéfices de l'opérateur, ventilés par type
-- Une opération TRANSFERT "avec frais de retrait" génère
-- 2 lignes ici : une pour TRANSFERT, une pour RETRAIT
-- ============================================
CREATE TABLE benefices (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operation_id INTEGER NOT NULL,
    type_operation_id INTEGER NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    date_benefice DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (operation_id) REFERENCES operations(id) ON DELETE CASCADE,
    FOREIGN KEY (type_operation_id) REFERENCES types_operation(id) ON DELETE CASCADE
);

CREATE INDEX idx_benefices_type ON benefices(type_operation_id);

-- ============================================
-- Variation des soldes clients
-- Une ligne par client affecté par une opération
-- (pour un transfert : 1 ligne expéditeur + 1 ligne destinataire)
-- ============================================
CREATE TABLE variation_soldes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    operation_id INTEGER,
    solde_avant DECIMAL(15,2) NOT NULL,
    solde_apres DECIMAL(15,2) NOT NULL,
    variation DECIMAL(15,2) NOT NULL,   -- solde_apres - solde_avant (positif ou négatif)
    date_variation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (operation_id) REFERENCES operations(id) ON DELETE SET NULL
);

CREATE INDEX idx_variation_client ON variation_soldes(client_id);

-- ============================================
-- Trigger : vérifie le préfixe à la création d'un client
-- ============================================
CREATE TRIGGER trg_verifier_prefixe
BEFORE INSERT ON clients
FOR EACH ROW
WHEN NOT EXISTS (
    SELECT 1 FROM prefixes_operateur
    WHERE actif = 1
    AND SUBSTR(NEW.numero_telephone, 1, 3) = prefixe
)
BEGIN
    SELECT RAISE(ABORT, 'Prefixe non valide pour l''operateur');
END;

-- ============================================
-- Vues opérateur
-- ============================================
CREATE VIEW vue_situation_comptes AS
SELECT id, numero_telephone, solde, date_creation, date_derniere_connexion
FROM clients
ORDER BY solde DESC;

CREATE VIEW vue_gains_frais AS
SELECT t.libelle AS type_operation, SUM(b.montant) AS total_frais
FROM benefices b
JOIN types_operation t ON t.id = b.type_operation_id
GROUP BY t.libelle;
