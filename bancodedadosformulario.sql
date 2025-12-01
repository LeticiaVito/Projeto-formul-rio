-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS registro_marca;

-- Selecionar o banco de dados
USE registro_marca;

-- Criar tabela para armazenar os dados do formulário
CREATE TABLE IF NOT EXISTS marcas (
    id INT AUTO_INCREMENT PRIMARY KEY,       -- ID único para cada registro
    name VARCHAR(100) NOT NULL,              -- Nome completo
    email VARCHAR(100) NOT NULL,             -- Email
    phone VARCHAR(20) NOT NULL,              -- Telefone
    segment VARCHAR(50) NOT NULL,            -- Segmento da marca
    marca VARCHAR(100) NOT NULL,             -- Nome da marca
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Data e hora de criação (opcional)
);

-- Caso você queira fazer um teste inserindo dados manualmente, você pode usar este comando de exemplo:

INSERT INTO marcas (name, email, phone, segment, marca) 
VALUES 
('João da Silva', 'joao.silva@example.com', '11987654321', 'Tecnologia', 'TechBrand');

select * from marcas
