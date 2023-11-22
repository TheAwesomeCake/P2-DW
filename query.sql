-- Tabelas
CREATE TABLE perfil (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) UNIQUE
);

INSERT INTO perfil (titulo) VALUES ('Usuario'), ('Administrador');

CREATE TABLE permissao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) UNIQUE
);

INSERT INTO permissao (nome) VALUES
    ('todosuser'), ('todosvenda'), ('graficoidade'), 
    ('criarprod'), ('criarvenda'), ('buscauser'), 
    ('buscaprod'), ('index'), ('criaruser'), 
    ('login'), ('todosprod');


CREATE TABLE perfil_permissao (
    id_perfil INT,
    id_permissao INT,
    FOREIGN KEY(id_perfil) REFERENCES perfil(id),
    FOREIGN KEY(id_permissao) REFERENCES permissao(id),
    PRIMARY KEY(id_perfil, id_permissao)
);

INSERT INTO perfil_permissao (id_perfil, id_permissao) VALUES
    (1, 4), (1, 7), (1, 8), (1, 10), (1, 11)
    (2, 1), (2, 2), (2, 3), (2, 4), (2, 5),
    (2, 6), (2, 7), (2, 8), (2, 9), (2, 10),
    (2, 11);

CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255),
    senha VARCHAR(255),
    criado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    perfil_id INT DEFAULT 1,
    FOREIGN KEY(perfil_id) REFERENCES perfil(id)
);

INSERT INTO usuario (nome, email, senha, perfil_id) VALUES
    ('admin', 'admin@gmail.com', '$2y$10$h8M7N3EKWqGA5OvBs3klb.C05fjqdjwD2NjsBzl5PvC4FxUapvXQ2', 2);

CREATE TABLE endereco (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cep VARCHAR(255) NOT NULL,
    rua VARCHAR(255) NOT NULL,
    bairro VARCHAR(255) NOT NULL,
    cidade VARCHAR(255) NOT NULL,
    uf VARCHAR(255) NOT NULL,
    iduser INT NOT NULL,
    FOREIGN KEY(iduser) REFERENCES usuario(id) ON DELETE CASCADE
);

INSERT INTO endereco (cep, rua, bairro, cidade, uf, iduser) VALUES
    ('01001000', 'Praça da Sé', 'Sé', 'São Paulo', 'SP', 1);

CREATE TABLE produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    quantidade INT NOT NULL DEFAULT 0,
    criado TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT NOT NULL,
    id_produto INT NOT NULL,
    FOREIGN KEY(id_usuario) REFERENCES usuario(id) ON DELETE CASCADE,
    FOREIGN KEY(id_produto) REFERENCES produto(id) ON DELETE CASCADE
);

-- Tabelas espelho para registros deletados
CREATE TABLE perfil_deleted (
    id INT PRIMARY KEY,
    titulo VARCHAR(255),
    deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE permissao_deleted (
    id INT PRIMARY KEY,
    nome VARCHAR(255),
    deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE perfil_permissao_deleted (
    id_perfil INT,
    id_permissao INT,
    deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usuario_deleted (
    id INT PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255),
    senha VARCHAR(255),
    criado TIMESTAMP,
    perfil_id INT,
    deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE endereco_deleted (
    id INT PRIMARY KEY,
    cep VARCHAR(255) NOT NULL,
    rua VARCHAR(255) NOT NULL,
    bairro VARCHAR(255) NOT NULL,
    cidade VARCHAR(255) NOT NULL,
    uf VARCHAR(255) NOT NULL,
    iduser INT NOT NULL,
    deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produto_deleted (
    id INT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    quantidade INT NOT NULL DEFAULT 0,
    criado TIMESTAMP,
    deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE venda_deleted (
    id INT PRIMARY KEY,
    data_registro TIMESTAMP NOT NULL,
    id_usuario INT NOT NULL,
    id_produto INT NOT NULL,
    deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabelas espelho para registros atualizados
CREATE TABLE perfil_updated (
    id INT PRIMARY KEY,
    titulo VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE permissao_updated (
    id INT PRIMARY KEY,
    nome VARCHAR(255),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE perfil_permissao_updated (
    id_perfil INT,
    id_permissao INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE usuario_updated (
    id INT PRIMARY KEY,
    nome VARCHAR(255),
    email VARCHAR(255),
    senha VARCHAR(255),
    criado TIMESTAMP,
    perfil_id INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE endereco_updated (
    id INT PRIMARY KEY,
    cep VARCHAR(255) NOT NULL,
    rua VARCHAR(255) NOT NULL,
    bairro VARCHAR(255) NOT NULL,
    cidade VARCHAR(255) NOT NULL,
    uf VARCHAR(255) NOT NULL,
    iduser INT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE produto_updated (
    id INT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    quantidade INT NOT NULL DEFAULT 0,
    criado TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE venda_updated (
    id INT PRIMARY KEY,
    data_registro TIMESTAMP NOT NULL,
    id_usuario INT NOT NULL,
    id_produto INT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Triggers para manter registros de exclusão na tabela espelho
DELIMITER //
CREATE TRIGGER before_delete_perfil
BEFORE DELETE ON perfil
FOR EACH ROW
BEGIN
    INSERT INTO perfil_deleted (id, titulo) VALUES (OLD.id, OLD.titulo);
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_delete_permissao
BEFORE DELETE ON permissao
FOR EACH ROW
BEGIN
    INSERT INTO permissao_deleted (id, nome) VALUES (OLD.id, OLD.nome);
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_delete_perfil_permissao
BEFORE DELETE ON perfil_permissao
FOR EACH ROW
BEGIN
    INSERT INTO perfil_permissao_deleted (id_perfil, id_permissao) VALUES (OLD.id_perfil, OLD.id_permissao);
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_delete_usuario
BEFORE DELETE ON usuario
FOR EACH ROW
BEGIN
    INSERT INTO usuario_deleted (id, nome, email, senha, criado, perfil_id) VALUES (OLD.id, OLD.nome, OLD.email, OLD.senha, OLD.criado, OLD.perfil_id);
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_delete_endereco
BEFORE DELETE ON endereco
FOR EACH ROW
BEGIN
    INSERT INTO endereco_deleted (id, cep, rua, bairro, cidade, uf, iduser) VALUES (OLD.id, OLD.cep, OLD.rua, OLD.bairro, OLD.cidade, OLD.uf, OLD.iduser);
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_delete_produto
BEFORE DELETE ON produto
FOR EACH ROW
BEGIN
    INSERT INTO produto_deleted (id, nome, preco, quantidade, criado) VALUES (OLD.id, OLD.nome, OLD.preco, OLD.quantidade, OLD.criado);
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_delete_venda
BEFORE DELETE ON venda
FOR EACH ROW
BEGIN
    INSERT INTO venda_deleted (id, data_registro, id_usuario, id_produto) VALUES (OLD.id, OLD.data_registro, OLD.id_usuario, OLD.id_produto);
END;
//
DELIMITER //

-- Triggers para manter registros de atualização na tabela espelho
DELIMITER //
CREATE TRIGGER before_update_perfil
BEFORE UPDATE ON perfil
FOR EACH ROW
BEGIN
    INSERT INTO perfil_updated (id, titulo, updated_at) VALUES (OLD.id, OLD.titulo, NOW());
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_update_permissao
BEFORE UPDATE ON permissao
FOR EACH ROW
BEGIN
    INSERT INTO permissao_updated (id, nome, updated_at) VALUES (OLD.id, OLD.nome, NOW());
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_update_perfil_permissao
BEFORE UPDATE ON perfil_permissao
FOR EACH ROW
BEGIN
    INSERT INTO perfil_permissao_updated (id_perfil, id_permissao, updated_at) VALUES (OLD.id_perfil, OLD.id_permissao, NOW());
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_update_usuario
BEFORE UPDATE ON usuario
FOR EACH ROW
BEGIN
    INSERT INTO usuario_updated (id, nome, email, senha, criado, perfil_id, updated_at) VALUES (OLD.id, OLD.nome, OLD.email, OLD.senha, OLD.criado, OLD.perfil_id, NOW());
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_update_endereco
BEFORE UPDATE ON endereco
FOR EACH ROW
BEGIN
    INSERT INTO endereco_updated (id, cep, rua, bairro, cidade, uf, iduser, updated_at) VALUES (OLD.id, OLD.cep, OLD.rua, OLD.bairro, OLD.cidade, OLD.uf, OLD.iduser, NOW());
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_update_produto
BEFORE UPDATE ON produto
FOR EACH ROW
BEGIN
    INSERT INTO produto_updated (id, nome, preco, quantidade, criado, updated_at) VALUES (OLD.id, OLD.nome, OLD.preco, OLD.quantidade, OLD.criado, NOW());
END;
//
DELIMITER //

DELIMITER //
CREATE TRIGGER before_update_venda
BEFORE UPDATE ON venda
FOR EACH ROW
BEGIN
    INSERT INTO venda_updated (id, data_registro, id_usuario, id_produto, updated_at) VALUES (OLD.id, OLD.data_registro, OLD.id_usuario, OLD.id_produto, NOW());
END;
//
DELIMITER //

-- VIEW para faixas etárias
CREATE VIEW idades AS
SELECT
  CASE
    WHEN TIMESTAMPDIFF(YEAR, data_nascimento, NOW()) <= 10 THEN 'Criança'
    WHEN TIMESTAMPDIFF(YEAR, data_nascimento, NOW()) > 10 AND TIMESTAMPDIFF(YEAR, data_nascimento, NOW()) <= 18 THEN 'Adolescente'
    WHEN TIMESTAMPDIFF(YEAR, data_nascimento, NOW()) > 18 THEN 'Adulto'
    ELSE 'Bebê'
  END as faixa_etaria,
  COUNT(data_nascimento) as quantidade_pessoas
FROM usuario
GROUP BY faixa_etaria;

-- VIEW para vendas por usuário
CREATE VIEW VendasPorUsuario AS
SELECT id_usuario, COUNT(id_produto) AS qtd_produtos
FROM venda
GROUP BY id_usuario;
