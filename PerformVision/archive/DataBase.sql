DROP TABLE IF EXISTS Utilisateur, Client, Formateur, Moderateur;
CREATE TABLE Utilisateur(
   idUtilisateur SERIAL,
   Nom VARCHAR(255) NOT NULL,
   Prenom VARCHAR(255) NOT NULL,
   Mail VARCHAR(255) NOT NULL,
   Role VARCHAR(50) NOT NULL,
   MotDePasse TEXT NOT NULL,
   EstAffranchi BOOLEAN NOT NULL,
   PRIMARY KEY(idUtilisateur)
);

CREATE TABLE Client(
   idUtilisateur INTEGER,
   PRIMARY KEY(idUtilisateur),
   FOREIGN KEY(idUtilisateur) REFERENCES Utilisateur(idUtilisateur)
);

CREATE TABLE Formateur(
   idUtilisateur_1 SMALLINT,
   Page_linkedin VARCHAR(255) NOT NULL,
   CV bytea NOT NULL,
   idUtilisateur SMALLINT NOT NULL,
   PRIMARY KEY(idUtilisateur_1),
   FOREIGN KEY(idUtilisateur_1) REFERENCES Utilisateur(idUtilisateur),
   FOREIGN KEY(idUtilisateur) REFERENCES Formateur(idUtilisateur_1)
);

CREATE TABLE Moderateur(
   idModerateur SMALLINT,
   idUtilisateur SMALLINT NOT NULL,
   PRIMARY KEY(idModerateur),
   FOREIGN KEY(idUtilisateur) REFERENCES Formateur(idUtilisateur_1)
);