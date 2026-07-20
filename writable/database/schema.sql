PRAGMA foreign_keys = ON;

-- Opérateur (compte admin)
CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_utilisateur VARCHAR(50) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    actif TINYINT NOT NULL DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_derniere_connexion DATETIME
);

-- Préfixes valides de l'opérateur
CREATE TABLE prefixes_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    prefixe VARCHAR(3) NOT NULL UNIQUE,
    actif TINYINT NOT NULL DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Types d'opérations
CREATE TABLE types_operation (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code VARCHAR(20) NOT NULL UNIQUE,
    libelle VARCHAR(50) NOT NULL,
    actif TINYINT NOT NULL DEFAULT 1
);

-- Barèmes de frais par tranche (différents par type d'opération)
CREATE TABLE baremes_frais (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_operation_id INTEGER NOT NULL,
    montant_min DECIMAL(15,2) NOT NULL,
    montant_max DECIMAL(15,2),
    frais_fixe DECIMAL(15,2) NOT NULL DEFAULT 0,
    frais_pourcentage DECIMAL(5,2) NOT NULL DEFAULT 0,
    actif TINYINT NOT NULL DEFAULT 1,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (type_operation_id) REFERENCES types_operation(id) ON DELETE CASCADE
);

-- Clients
CREATE TABLE clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero_telephone VARCHAR(15) NOT NULL UNIQUE,
    solde DECIMAL(15,2) NOT NULL DEFAULT 0,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_derniere_connexion DATETIME,
    actif TINYINT NOT NULL DEFAULT 1
);

-- Opérations (historique)
CREATE TABLE operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    reference VARCHAR(30) NOT NULL UNIQUE,
    type_operation_id INTEGER NOT NULL,
    client_id INTEGER NOT NULL,
    client_destinataire_id INTEGER,
    montant DECIMAL(15,2) NOT NULL,
    frais DECIMAL(15,2) NOT NULL DEFAULT 0,
    frais_transfert DECIMAL(15,2) NOT NULL DEFAULT 0,
    frais_retrait_anticipe DECIMAL(15,2) NOT NULL DEFAULT 0,
    option_transfert VARCHAR(25),
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

-- Bénéfices de l'opérateur, ventilés par type
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

-- Variation des soldes clients
CREATE TABLE variation_soldes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    operation_id INTEGER,
    solde_avant DECIMAL(15,2) NOT NULL,
    solde_apres DECIMAL(15,2) NOT NULL,
    variation DECIMAL(15,2) NOT NULL,
    date_variation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE,
    FOREIGN KEY (operation_id) REFERENCES operations(id) ON DELETE SET NULL
);

CREATE INDEX idx_variation_client ON variation_soldes(client_id);

-- Trigger : vérifie le préfixe à la création d'un client
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

-- Vues opérateur
CREATE VIEW vue_situation_comptes AS
SELECT id, numero_telephone, solde, date_creation, date_derniere_connexion
FROM clients
ORDER BY solde DESC;

CREATE VIEW vue_gains_frais AS
SELECT t.libelle AS type_operation, SUM(b.montant) AS total_frais
FROM benefices b
JOIN types_operation t ON t.id = b.type_operation_id
GROUP BY t.libelle;