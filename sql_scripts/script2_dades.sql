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
INSERT INTO estat_cursa VALUES
    (NULL, 'En preparació'),
    (NULL, 'Inscripció Oberta'),
    (NULL, 'Inscripció Tancada'),
    (NULL, 'En curs'),
    (NULL, 'Finalitzada'),
    (NULL, 'Cancelada');
    
-- Esports + Categories
   -- 2 esports i 2 categories
INSERT INTO esport VALUES (NULL,'Ciclisme');
SET @last_id = LAST_INSERT_ID();
INSERT INTO categories VALUES (NULL,@last_id,'infantil');
INSERT INTO categories VALUES (NULL,@last_id,'cadet');
INSERT INTO categories VALUES (NULL,@last_id,'junior');


INSERT INTO esport VALUES (NULL,'Running');
SET @last_id = LAST_INSERT_ID();
INSERT INTO categories VALUES (NULL,@last_id,'Casual')
INSERT INTO categories VALUES (NULL,@last_id,'Profesional')




-- Categories
    --
INSERT INTO categories VALUES
    (NULL,)