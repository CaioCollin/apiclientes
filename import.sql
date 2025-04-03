CREATE DATABASE cadastro_cliente;

USE cadastro_cliente;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,   
    cpf VARCHAR(14) NOT NULL,             
    nome VARCHAR(255) NOT NULL,
    datanascimento DATE NOT NULL,
    endereco TEXT NOT NULL,
    UNIQUE (cpf)                         
);

CREATE TABLE contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,    
    cliente_id INT NOT NULL,              
    tipo VARCHAR(50) NOT NULL,            
    valor VARCHAR(255) NOT NULL,          
    observacao TEXT,                      
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE  
);
