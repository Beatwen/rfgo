CREATE DATABASE IF NOT EXISTS RF_GoUSERS DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;

USE RF_GoUSERS;

CREATE TABLE t_utilisateur_uti (
    uti_id INT PRIMARY KEY AUTO_INCREMENT,
    uti_pseudo VARCHAR(255) UNIQUE NOT NULL,
    uti_email VARCHAR(255) UNIQUE NOT NULL,
    uti_motdepasse VARBINARY(60) NOT NULL,
    uti_role ENUM('Utilisateur', 'Administrateur') DEFAULT 'Utilisateur',
    uti_compte_active BOOLEAN DEFAULT 0,
    uti_code_activation CHAR(5)
) ENGINE=InnoDB;
rf_gousers