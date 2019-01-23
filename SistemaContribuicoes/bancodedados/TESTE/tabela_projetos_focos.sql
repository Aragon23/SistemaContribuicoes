CREATE TABLE IF NOT EXISTS projetos_focosdeanalise(
	projetos_focos_id INT PRIMARY KEY AUTO_INCREMENT,
    projeto INT NOT NULL,
    focodeanalise INT NOT NULL,
    
    FOREIGN KEY(projeto) REFERENCES projetos(id_projeto) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(focodeanalise) REFERENCES focosdeanalise(id_focodeanalise) ON DELETE CASCADE ON UPDATE CASCADE
    
) engine = innoDB;