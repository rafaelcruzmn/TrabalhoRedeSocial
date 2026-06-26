CREATE DATABASE RedeSocial;

USE RedeSocial;

CREATE TABLE Usuario (

    idUsuario INT AUTO_INCREMENT PRIMARY KEY,

    Usuario VARCHAR(45) NOT NULL UNIQUE,

    Senha VARCHAR(255) NOT NULL,

    Email VARCHAR(200) NOT NULL UNIQUE,

    Descricao VARCHAR(255)

);


CREATE TABLE Post (

    idPost INT AUTO_INCREMENT PRIMARY KEY,

    Descricao VARCHAR(100),

    Titulo VARCHAR(30) NOT NULL,

    Texto VARCHAR(255) NOT NULL,

    DataPost DATETIME DEFAULT CURRENT_TIMESTAMP,


    Usuario_idUsuario INT NOT NULL,


    CONSTRAINT fk_Post_Usuario

    FOREIGN KEY (Usuario_idUsuario)

    REFERENCES Usuario(idUsuario)

    ON DELETE CASCADE

);

CREATE TABLE Comentario (

    idComentario INT AUTO_INCREMENT PRIMARY KEY,


    Texto VARCHAR(255) NOT NULL,


    DataComent DATETIME DEFAULT CURRENT_TIMESTAMP,


    Post_idPost INT NOT NULL,

    Usuario_idUsuario INT NOT NULL,


    CONSTRAINT fk_Comentario_Post

    FOREIGN KEY (Post_idPost)

    REFERENCES Post(idPost)

    ON DELETE CASCADE,


    CONSTRAINT fk_Comentario_Usuario

    FOREIGN KEY (Usuario_idUsuario)

    REFERENCES Usuario(idUsuario)

    ON DELETE CASCADE

);

CREATE TABLE Likes (

    idLikes INT AUTO_INCREMENT PRIMARY KEY,


    Usuario_idUsuario INT NOT NULL,

    Post_idPost INT NOT NULL,


    CONSTRAINT fk_Like_Usuario

    FOREIGN KEY (Usuario_idUsuario)

    REFERENCES Usuario(idUsuario)

    ON DELETE CASCADE,


    CONSTRAINT fk_Like_Post

    FOREIGN KEY (Post_idPost)

    REFERENCES Post(idPost)

    ON DELETE CASCADE,

    UNIQUE(
        Usuario_idUsuario,
        Post_idPost
    )

);