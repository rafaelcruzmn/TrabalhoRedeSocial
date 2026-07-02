CREATE DATABASE RedeSocial;

USE RedeSocial;

CREATE TABLE Usuario (
    idusuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(45) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    email VARCHAR(200) NOT NULL UNIQUE,
    descricao VARCHAR(255)
);

CREATE TABLE Post (
    idpost INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(100),
    titulo VARCHAR(30) NOT NULL,
    texto VARCHAR(255) NOT NULL,
    datapost DATETIME DEFAULT CURRENT_TIMESTAMP,
    imagem VARCHAR(255) NULL DEFAULT NULL,
    usuario_idusuario INT NOT NULL,

    CONSTRAINT fk_Post_Usuario
    FOREIGN KEY (usuario_idusuario)
    REFERENCES Usuario(idusuario)
    ON DELETE CASCADE
);

CREATE TABLE Comentario (
    idcomentario INT AUTO_INCREMENT PRIMARY KEY,
    texto VARCHAR(255) NOT NULL,
    datacoment DATETIME DEFAULT CURRENT_TIMESTAMP,
    post_idpost INT NOT NULL,
    usuario_idusuario INT NOT NULL,

    CONSTRAINT fk_Comentario_Post
    FOREIGN KEY (post_idpost)
    REFERENCES Post(idpost)
    ON DELETE CASCADE,

    CONSTRAINT fk_Comentario_Usuario
    FOREIGN KEY (usuario_idusuario)
    REFERENCES Usuario(idusuario)
    ON DELETE CASCADE
);

CREATE TABLE Likes (
    idlikes INT AUTO_INCREMENT PRIMARY KEY,
    usuario_idusuario INT NOT NULL,
    post_idpost INT NOT NULL,

    CONSTRAINT fk_Like_Usuario
    FOREIGN KEY (usuario_idusuario)
    REFERENCES Usuario(idusuario)
    ON DELETE CASCADE,

    CONSTRAINT fk_Like_Post
    FOREIGN KEY (post_idpost)
    REFERENCES Post(idpost)
    ON DELETE CASCADE,

    UNIQUE(
        usuario_idusuario,
        post_idpost
    )
);