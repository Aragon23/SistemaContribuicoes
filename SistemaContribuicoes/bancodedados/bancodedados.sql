CREATE DATABASE IF NOT EXISTS contribuicoes;
USE contribuicoes;

CREATE TABLE IF NOT EXISTS empresas(
	id_empresa INT PRIMARY KEY AUTO_INCREMENT,
    nome_empresa VARCHAR (100) UNIQUE NOT NULL
) engine = innoDB;

CREATE TABLE IF NOT EXISTS participantes(
	id_participante INT PRIMARY KEY AUTO_INCREMENT,
    username_participante VARCHAR(50) UNIQUE NOT NULL,
    senha_participante VARCHAR(20) NOT NULL,
    nome_participante VARCHAR(100) NOT NULL,
    empresa_participante INT NOT NULL,
    
    FOREIGN KEY(empresa_participante) REFERENCES empresas(id_empresa) ON DELETE CASCADE ON UPDATE CASCADE
    
) engine=innoDB;

CREATE TABLE IF NOT EXISTS empresas_participantes(
	id_empresa_participante INT PRIMARY KEY AUTO_INCREMENT,
    participante INT,
    empresa INT,
    
    FOREIGN KEY(participante) REFERENCES participantes(id_participante) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(empresa) REFERENCES empresas(id_empresa) ON DELETE CASCADE ON UPDATE CASCADE
    
) engine = innoDB;

CREATE TABLE IF NOT EXISTS projetos(
	id_projeto INT PRIMARY KEY AUTO_INCREMENT,
    nome_projeto VARCHAR(100) UNIQUE NOT NULL
    
) engine=innoDB;

CREATE TABLE IF NOT EXISTS projetos_participantes(
	id_projetos_participantes INT PRIMARY KEY AUTO_INCREMENT,
    participante INT NOT NULL,
    projeto INT NOT NULL,
    empresa INT NOT NULL,
    
    FOREIGN KEY(participante) REFERENCES participantes(id_participante) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(projeto) REFERENCES projetos(id_projeto) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(empresa) REFERENCES empresas(id_empresa) ON DELETE CASCADE ON UPDATE CASCADE
    
) engine = innoDB;

CREATE TABLE IF NOT EXISTS focosdeanalise(
	id_focodeanalise INT PRIMARY KEY AUTO_INCREMENT,
    nome_focodeanalise VARCHAR(100) NOT NULL,
    projeto_focodeanalise INT NOT NULL,
    
    FOREIGN KEY(projeto_focodeanalise) REFERENCES projetos(id_projeto) ON DELETE CASCADE ON UPDATE CASCADE
    
) engine=innoDB;

CREATE TABLE IF NOT EXISTS contribuicoes(
	id_contribuicao INT PRIMARY KEY AUTO_INCREMENT,
    nome_contribuicao VARCHAR(255) NOT NULL,
	participante_contribuicao INT NOT NULL,
    empresa_contribuicao INT NOT NULL,
    projeto_contribuicao INT NOT NULL,
    focodeanalise_contribuicao INT NOT NULL,
    
    FOREIGN KEY(participante_contribuicao)  REFERENCES participantes(id_participante),
    FOREIGN KEY(empresa_contribuicao)       REFERENCES empresas(id_empresa),
    FOREIGN KEY(projeto_contribuicao)       REFERENCES projetos(id_projeto),
    FOREIGN KEY(focodeanalise_contribuicao) REFERENCES focosdeanalise(id_focodeanalise)

) engine=innoDB;
    