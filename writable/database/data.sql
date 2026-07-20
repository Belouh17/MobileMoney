INSERT INTO operateurs (nom_utilisateur, mot_de_passe) VALUES
('admin', '$2y$10$exempleHashRemplaceParPasswordHash');

INSERT INTO prefixes_operateur (prefixe) VALUES ('033'), ('037');

INSERT INTO types_operation (code, libelle) VALUES
('DEPOT', 'Dépôt'),
('RETRAIT', 'Retrait'),
('TRANSFERT', 'Transfert');

INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES
(1, 0, NULL, 0);

INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES
(2, 100, 1000, 50),
(2, 1001, 5000, 50),
(2, 5001, 10000, 100),
(2, 10001, 25000, 200),
(2, 25001, 50000, 400),
(2, 50001, 100000, 800),
(2, 100001, 250000, 1500),
(2, 250001, 500000, 1500),
(2, 500001, 1000000, 2500),
(2, 1000001, 2000000, 3000);

INSERT INTO baremes_frais (type_operation_id, montant_min, montant_max, frais_fixe) VALUES
(3, 0, 10000, 200),
(3, 10001, 50000, 500),
(3, 50001, NULL, 800);

INSERT INTO clients (numero_telephone, solde) VALUES
('0331234567', 15000),
('0337654321', 60000),
('0371112233', 0),
('0374445566', 140500);

INSERT INTO operations (reference, type_operation_id, client_id, montant, frais, solde_avant, solde_apres) VALUES
('OP0001', 1, 1, 10000, 0, 5000, 15000);
INSERT INTO variation_soldes (client_id, operation_id, solde_avant, solde_apres, variation) VALUES (1, 1, 5000, 15000, 10000);

INSERT INTO operations (reference, type_operation_id, client_id, montant, frais, solde_avant, solde_apres) VALUES
('OP0002', 2, 2, 10000, 100, 60000, 59900);
INSERT INTO variation_soldes (client_id, operation_id, solde_avant, solde_apres, variation) VALUES (2, 2, 60000, 59900, -100);
INSERT INTO benefices (operation_id, type_operation_id, montant) VALUES (2, 2, 100);

INSERT INTO operations
(reference, type_operation_id, client_id, client_destinataire_id, montant, frais, frais_transfert, frais_retrait_anticipe, option_transfert, solde_avant, solde_apres)
VALUES
('OP0003', 3, 4, 3, 20000, 700, 500, 200, 'AVEC_FRAIS_RETRAIT', 140500, 119800);
UPDATE clients SET solde = solde + 20200 WHERE id = 3;
INSERT INTO variation_soldes (client_id, operation_id, solde_avant, solde_apres, variation) VALUES
(4, 3, 140500, 119800, -20700),
(3, 3, 0, 20200, 20200);
INSERT INTO benefices (operation_id, type_operation_id, montant) VALUES
(3, 3, 500),
(3, 2, 200);