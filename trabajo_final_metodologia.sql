-- =====================================================
-- SISTEMA: Trabajo_final_metodologia
-- DESCRIPCIÓN: Sistema de gestión de notas personales
-- MOTOR: MariaDB
-- MODELO: Relacional normalizado hasta 3FN
-- =====================================================


-- =====================================================
-- 1) CREACIÓN DE LA BASE DE DATOS
-- =====================================================
CREATE DATABASE IF NOT EXISTS trabajo_final_metodologia
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE trabajo_final_metodologia;


-- =====================================================
-- 2) TABLA: usuarios
-- Almacena los usuarios del sistema
-- =====================================================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL UNIQUE,
    correo_electronico VARCHAR(100) NOT NULL UNIQUE,
    hash_contrasena VARCHAR(255) NOT NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Explicación:
-- - id_usuario: clave primaria
-- - hash_contrasena: seguridad (no texto plano)
-- - UNIQUE evita duplicados


-- =====================================================
-- 3) TABLA: notas
-- Contiene las notas creadas por los usuarios
-- =====================================================
CREATE TABLE notas (
    id_nota INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    titulo_nota VARCHAR(150) NOT NULL,
    contenido_nota TEXT NOT NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
    nota_archivada BOOLEAN NOT NULL DEFAULT FALSE,
    nota_destacada BOOLEAN NOT NULL DEFAULT FALSE,
    fecha_limite DATE NULL,

    CONSTRAINT fk_notas_usuario_creador
        FOREIGN KEY (id_usuario)
        REFERENCES usuarios(id_usuario)
        ON DELETE RESTRICT
);

-- Explicación:
-- - titulo_nota es obligatorio
-- - nota_archivada evita eliminación física
-- - nota_destacada permite marcar favoritas
-- - ON DELETE RESTRICT protege datos del usuario


-- =====================================================
-- 4) TABLA: etiquetas
-- Categorías aplicables a las notas
-- =====================================================
CREATE TABLE etiquetas (
    id_etiqueta INT AUTO_INCREMENT PRIMARY KEY,
    nombre_etiqueta VARCHAR(50) NOT NULL UNIQUE
);

-- Explicación:
-- - Cada etiqueta es única
-- - Se mantiene separada para cumplir 3FN


-- =====================================================
-- 5) TABLA: notas_etiquetas
-- Relación MUCHOS A MUCHOS entre notas y etiquetas
-- =====================================================
CREATE TABLE notas_etiquetas (
    id_nota INT NOT NULL,
    id_etiqueta INT NOT NULL,

    PRIMARY KEY (id_nota, id_etiqueta),

    CONSTRAINT fk_notas_etiquetas_nota
        FOREIGN KEY (id_nota)
        REFERENCES notas(id_nota)
        ON DELETE CASCADE,

    CONSTRAINT fk_notas_etiquetas_etiqueta
        FOREIGN KEY (id_etiqueta)
        REFERENCES etiquetas(id_etiqueta)
        ON DELETE CASCADE
);

-- Explicación:
-- - Clave primaria compuesta evita duplicados
-- - CASCADE elimina relaciones automáticamente


-- =====================================================
-- 6) DATOS DE EJEMPLO (OPCIONAL PARA PRUEBAS)
-- =====================================================

-- Usuario de ejemplo
INSERT INTO usuarios (nombre_usuario, correo_electronico, hash_contrasena)
VALUES ('jorge', 'jorge@mail.com', 'hash_contrasena_segura');

-- Nota de ejemplo
INSERT INTO notas (
    id_usuario,
    titulo_nota,
    contenido_nota,
    nota_destacada
) VALUES (
    1,
    'Nota de ejemplo',
    'Contenido de prueba para el trabajo práctico',
    TRUE
);

-- Etiquetas de ejemplo
INSERT INTO etiquetas (nombre_etiqueta)
VALUES ('estudio'), ('personal');

-- Asociación nota - etiquetas
INSERT INTO notas_etiquetas (id_nota, id_etiqueta)
VALUES (1, 1), (1, 2);


-- =====================================================
-- 7) CONSULTAS DE USO FRECUENTE
-- =====================================================

-- Listar notas activas de un usuario
SELECT titulo_nota, fecha_creacion, fecha_modificacion
FROM notas
WHERE id_usuario = 1
  AND nota_archivada = FALSE;

-- Buscar notas por título
SELECT *
FROM notas
WHERE id_usuario = 1
  AND titulo_nota LIKE '%ejemplo%';

-- Búsqueda avanzada (título y contenido)
SELECT *
FROM notas
WHERE id_usuario = 1
  AND (titulo_nota LIKE '%prueba%'
       OR contenido_nota LIKE '%prueba%');

-- Ordenar por fecha de creación
SELECT *
FROM notas
WHERE id_usuario = 1
ORDER BY fecha_creacion DESC;

-- Buscar notas por etiqueta
SELECT notas.*
FROM notas
JOIN notas_etiquetas
  ON notas.id_nota = notas_etiquetas.id_nota
JOIN etiquetas
  ON notas_etiquetas.id_etiqueta = etiquetas.id_etiqueta
WHERE etiquetas.nombre_etiqueta = 'estudio'
  AND notas.id_usuario = 1;

-- Archivar una nota (eliminación lógica)
UPDATE notas
SET nota_archivada = TRUE
WHERE id_nota = 1;


-- =====================================================
-- FIN DEL ARCHIVO SQL
-- =====================================================