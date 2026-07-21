-- ==========================
-- OPERATEUR
-- ==========================

INSERT INTO operateurs (nom_utilisateur, mot_de_passe)
VALUES
('admin', '$2y$10$UoBKnWQ2cbaP5vBeqwHqN.Si6RmCBQoBHC4PCIvVcnygCPjnjMODu');

-- ==========================
-- PREFIXES DE NOTRE OPERATEUR
-- ==========================

INSERT INTO prefixes_operateur (prefixe)
VALUES
('034'),
('038'),
('033');

-- ==========================
-- TYPES D'OPERATIONS
-- ==========================

INSERT INTO types_operation (code, libelle)
VALUES
('DEPOT', 'Dépôt'),
('RETRAIT', 'Retrait'),
('TRANSFERT', 'Transfert');

-- ==========================
-- AUTRES OPERATEURS
-- ==========================

INSERT INTO autres_operateurs (nom, commission_pourcentage)
VALUES
('Orange Money',2),
('Airtel Money',1.5),
('MVola',2.5);

-- ==========================
-- PREFIXES DES AUTRES OPERATEURS
-- ==========================

INSERT INTO autres_operateurs_prefixes (autre_operateur_id,prefixe)
VALUES
(1,'032'),
(2,'039'),
(3,'037');

-- ==========================
-- BAREMES
-- ==========================

INSERT INTO baremes_frais
(type_operation_id,montant_min,montant_max,frais_fixe,frais_pourcentage)
VALUES

-- Dépôt
(1,0,50000,0,0),
(1,50001,NULL,0,0),

-- Retrait
(2,0,50000,500,0),
(2,50001,100000,1000,0),
(2,100001,NULL,1500,0),

-- Transfert
(3,0,50000,300,1),
(3,50001,100000,500,1),
(3,100001,NULL,1000,1);

-- ==========================
-- CLIENTS
-- ==========================

INSERT INTO clients (numero_telephone,solde)
VALUES
('0341234567',500000),
('0349876543',250000),
('0381111111',150000),
('0332222222',100000),
('0343333333',50000);

-- ==========================
-- OPERATIONS
-- ==========================

INSERT INTO operations
(
reference,
type_operation_id,
client_id,
client_destinataire_id,
autre_operateur_id,
reference_lot,
montant,
frais,
frais_transfert,
frais_retrait_anticipe,
option_transfert,
solde_avant,
solde_apres
)
VALUES

(
'OP000001',
1,
1,
NULL,
NULL,
NULL,
100000,
0,
0,
0,
NULL,
400000,
500000
),

(
'OP000002',
2,
2,
NULL,
NULL,
NULL,
50000,
500,
0,
0,
NULL,
300000,
249500
),

(
'OP000003',
3,
1,
3,
NULL,
NULL,
25000,
550,
550,
0,
'INTERNE',
500000,
474450
),

(
'OP000004',
3,
4,
NULL,
1,
'LOT001',
40000,
700,
700,
0,
'EXTERNE',
100000,
59300
),

(
'OP000005',
3,
5,
NULL,
2,
'LOT001',
10000,
400,
400,
0,
'EXTERNE',
50000,
39600
);

-- ==========================
-- BENEFICES
-- ==========================

INSERT INTO benefices
(operation_id,type_operation_id,montant)
VALUES
(2,2,500),
(3,3,550),
(4,3,700),
(5,3,400);

-- ==========================
-- VARIATIONS DES SOLDES
-- ==========================

INSERT INTO variation_soldes
(client_id,operation_id,solde_avant,solde_apres,variation)
VALUES

(1,1,400000,500000,100000),

(2,2,300000,249500,-50500),

(1,3,500000,474450,-25550),

(3,3,125000,150000,25000),

(4,4,100000,59300,-40700),

(5,5,50000,39600,-10400);