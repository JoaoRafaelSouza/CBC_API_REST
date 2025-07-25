CREATE DATABASE IF NOT EXISTS cbc_api;
USE cbc_api;

CREATE TABLE recursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recurso VARCHAR(255) NOT NULL,
    saldo_disponivel DECIMAL(10,2) NOT NULL,
    ativado BIT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE clubes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clube VARCHAR(255) NOT NULL,
    saldo_disponivel DECIMAL(10,2) NOT NULL,
    ativado BIT NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO recursos (recurso, saldo_disponivel, ativado) VALUES 
('Recurso para passagens', 10000.00, 1),
('Recurso para hospedagens', 10000.00, 1);

INSERT INTO clubes (clube, saldo_disponivel, ativado) VALUES 
('Clube A', 2000.00, 1),
('Clube B', 3000.00, 1);