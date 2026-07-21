PRAGMA foreign_keys = ON;

-- ==========================
-- OPERATEURS
-- ==========================

CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_utilisateur TEXT NOT NULL UNIQUE,
    mot_de_passe TEXT NOT NULL,
    actif INTEGER NOT NULL DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_derniere_connexion DATETIME
);

CREATE TABLE prefixes_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe TEXT NOT NULL UNIQUE,
    actif INTEGER NOT NULL DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ==========================
-- TYPES D'OPERATIONS
-- ==========================

CREATE TABLE types_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE,
    libelle TEXT NOT NULL,
    actif INTEGER NOT NULL DEFAULT 1
);

-- ==========================
-- AUTRES OPERATEURS
-- ==========================

CREATE TABLE autres_operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    commission_pourcentage DECIMAL(5,2) NOT NULL DEFAULT 0,
    actif INTEGER NOT NULL DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE autres_operateurs_prefixes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    autre_operateur_id INTEGER NOT NULL,
    prefixe TEXT NOT NULL UNIQUE,
    actif INTEGER NOT NULL DEFAULT 1,
    FOREIGN KEY (autre_operateur_id)
        REFERENCES autres_operateurs(id)
        ON DELETE CASCADE
);

-- ==========================
-- BAREMES DE FRAIS
-- ==========================

CREATE TABLE baremes_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    montant_min DECIMAL(15,2) NOT NULL,
    montant_max DECIMAL(15,2),
    frais_fixe DECIMAL(15,2) NOT NULL DEFAULT 0,
    frais_pourcentage DECIMAL(5,2) NOT NULL DEFAULT 0,
    actif INTEGER NOT NULL DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (type_operation_id)
        REFERENCES types_operation(id)
        ON DELETE CASCADE
);

CREATE TABLE promotions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    promo_pourcentage DECIMAL(5,2) NOT NULL DEFAULT 0
);

-- ==========================
-- CLIENTS
-- ==========================

CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_telephone TEXT NOT NULL UNIQUE,
    solde DECIMAL(15,2) NOT NULL DEFAULT 0,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_derniere_connexion DATETIME,
    actif INTEGER NOT NULL DEFAULT 1
);

-- ==========================
-- OPERATIONS
-- ==========================

CREATE TABLE operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    reference TEXT NOT NULL UNIQUE,
    type_operation_id INTEGER NOT NULL,
    client_id INTEGER NOT NULL,
    client_destinataire_id INTEGER,
    autre_operateur_id INTEGER,
    reference_lot TEXT,
    montant DECIMAL(15,2) NOT NULL,
    frais DECIMAL(15,2) NOT NULL DEFAULT 0,
    frais_transfert DECIMAL(15,2) NOT NULL DEFAULT 0,
    frais_retrait_anticipe DECIMAL(15,2) NOT NULL DEFAULT 0,
    option_transfert TEXT,
    solde_avant DECIMAL(15,2) NOT NULL,
    solde_apres DECIMAL(15,2) NOT NULL,
    date_operation DATETIME DEFAULT CURRENT_TIMESTAMP,
    statut TEXT NOT NULL DEFAULT 'REUSSI',

    FOREIGN KEY (type_operation_id)
        REFERENCES types_operation(id)
        ON DELETE CASCADE,

    FOREIGN KEY (client_id)
        REFERENCES clients(id)
        ON DELETE CASCADE,

    FOREIGN KEY (client_destinataire_id)
        REFERENCES clients(id)
        ON DELETE SET NULL,

    FOREIGN KEY (autre_operateur_id)
        REFERENCES autres_operateurs(id)
);

CREATE INDEX idx_operations_client
ON operations(client_id);

CREATE INDEX idx_operations_date
ON operations(date_operation);

-- ==========================
-- BENEFICES
-- ==========================

CREATE TABLE benefices (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    operation_id INTEGER NOT NULL,
    type_operation_id INTEGER NOT NULL,
    montant DECIMAL(15,2) NOT NULL,
    date_benefice DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (operation_id)
        REFERENCES operations(id)
        ON DELETE CASCADE,

    FOREIGN KEY (type_operation_id)
        REFERENCES types_operation(id)
        ON DELETE CASCADE
);

CREATE INDEX idx_benefices_type
ON benefices(type_operation_id);

-- ==========================
-- VARIATION DES SOLDES
-- ==========================

CREATE TABLE variation_soldes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    operation_id INTEGER,
    solde_avant DECIMAL(15,2) NOT NULL,
    solde_apres DECIMAL(15,2) NOT NULL,
    variation DECIMAL(15,2) NOT NULL,
    date_variation DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (client_id)
        REFERENCES clients(id)
        ON DELETE CASCADE,

    FOREIGN KEY (operation_id)
        REFERENCES operations(id)
        ON DELETE SET NULL
);

CREATE INDEX idx_variation_client
ON variation_soldes(client_id);

-- ==========================
-- TRIGGER
-- ==========================

CREATE TRIGGER trg_verifier_prefixe
BEFORE INSERT ON clients
FOR EACH ROW
WHEN NOT EXISTS (
    SELECT 1
    FROM prefixes_operateur
    WHERE actif = 1
      AND prefixe = SUBSTR(NEW.numero_telephone,1,3)
)
BEGIN
    SELECT RAISE(ABORT,'Prefixe non valide pour l''operateur');
END;

-- ==========================
-- VUES
-- ==========================

CREATE VIEW vue_situation_comptes AS
SELECT
    id,
    numero_telephone,
    solde,
    date_creation,
    date_derniere_connexion
FROM clients
ORDER BY solde DESC;

CREATE VIEW vue_gains_frais AS
SELECT
    CASE
        WHEN o.autre_operateur_id IS NULL
            THEN 'Notre opérateur'
        ELSE ao.nom
    END AS reseau,

    t.libelle AS type_operation,

    SUM(b.montant) AS total_frais

FROM benefices b

JOIN operations o
    ON o.id = b.operation_id

JOIN types_operation t
    ON t.id = b.type_operation_id

LEFT JOIN autres_operateurs ao
    ON ao.id = o.autre_operateur_id

GROUP BY reseau, t.libelle;

CREATE VIEW vue_montants_a_envoyer AS
SELECT
    ao.nom AS autre_operateur,
    SUM(o.montant) AS montant_total_a_envoyer
FROM operations o
JOIN autres_operateurs ao
    ON ao.id = o.autre_operateur_id
WHERE o.autre_operateur_id IS NOT NULL
GROUP BY ao.nom;