-- Usuaris
    -- 2 Amins
    -- 2 No admins
INSERT INTO usuaris VALUES 
    (NULL,'ngarrido','1234',1),
    (NULL,'dcano','1234',1),
    (NULL,'aparera','1234',0),
    (NULL,'acarrillo','1234',0);
    
-- Estat Curses
    -- 6 estats
INSERT INTO estats_cursa VALUES
    (NULL, 'En preparació'),
    (NULL, 'Inscripció Oberta'),
    (NULL, 'Inscripció Tancada'),
    (NULL, 'En curs'),
    (NULL, 'Finalitzada'),
    (NULL, 'Cancelada');
    
-- Esports + Categories
   -- 2 esports i 6 categories
INSERT INTO esports VALUES (NULL,'Ciclisme');
SET @last_id = LAST_INSERT_ID();
INSERT INTO categories VALUES (NULL,@last_id,'infantil');
INSERT INTO categories VALUES (NULL,@last_id,'cadet');
INSERT INTO categories VALUES (NULL,@last_id,'junior');
INSERT INTO categories VALUES (NULL,@last_id,'senior');

INSERT INTO esports VALUES (NULL,'Running');
SET @last_id = LAST_INSERT_ID();
INSERT INTO categories VALUES (NULL,@last_id,'Casual');
INSERT INTO categories VALUES (NULL,@last_id,'Profesional');

-- Beacons
    -- 4 beacons
INSERT INTO beacons VALUES 
    (NULL, 'bR1S7!Gc(BS!?%-uY/_K)Te!$m9j6b'),
    (NULL, '+M1N;3cvkMZ:fThS$[WnvH&{J2G9:$'),
    (NULL, 'y;AcyeqcMaCUB[K_+F:gCnJ&=:;v(4'),
    (NULL, 'LWtWL{j&m[8}e5G1iMZAywJyif};%h');