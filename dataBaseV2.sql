DROP TABLE IF EXISTS utilisateur, client, formateur, moderateur;

CREATE TABLE utilisateur(
   id_utilisateur SERIAL,
   nom VARCHAR(255) NOT NULL,
   prenom VARCHAR(255) NOT NULL,
   mail VARCHAR(255) NOT NULL,
   password VARCHAR(255) NOT NULL,
   telephone INTEGER,
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE client(
   id_client INTEGER,
   PRIMARY KEY(id_client),
   FOREIGN KEY(id_client) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE formateur(
   id_formateur SMALLINT,
   linkedin VARCHAR(255) NOT NULL,
   cv bytea NOT NULL,
   date_signature date NOT NULL,
   PRIMARY KEY(id_formateur),
   FOREIGN KEY(id_formateur) REFERENCES Utilisateur(id_utilisateur)
);

CREATE TABLE moderateur(
   id_moderateur SMALLINT,

   PRIMARY KEY(id_moderateur),
   FOREIGN KEY(id_moderateur) REFERENCES Formateur(id_utilisateur)
);

