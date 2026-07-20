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
SELECT 'Retrait' AS type_operation,
       SUM(CASE WHEN t.code = 'RETRAIT' THEN o.frais ELSE 0 END)
       + SUM(o.frais_retrait_anticipe) AS total_frais
FROM operations o
JOIN types_operation t ON t.id = o.type_operation_id

UNION ALL

SELECT 'Transfert' AS type_operation,
       SUM(CASE WHEN t.code = 'TRANSFERT' THEN o.frais_transfert ELSE 0 END) AS total_frais
FROM operations o
JOIN types_operation t ON t.id = o.type_operation_id;