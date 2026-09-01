CREATE DATABASE IF NOT EXISTS loja_etim;
USE loja_etim;

CREATE TABLE produtos(
    id_produto int AUTO_INCREMENT PRIMARY KEY,
    nome_produto varchar(100),
    descricao text,
    valor decimal(10,2)
);

CREATE TABLE imagens(
    id_imagem int AUTO_INCREMENT PRIMARY KEY,
    nome_imagem varchar(100),
    fk_id_produto int,
    FOREIGN KEY (fk_id_produto) REFERENCES produtos(id_produto)
);