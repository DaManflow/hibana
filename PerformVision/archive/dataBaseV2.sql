DROP TABLE IF EXISTS utilisateur, client, formateur, moderateur;

CREATE TABLE utilisateur(
   id_utilisateur SERIAL,
   nom VARCHAR(255) NOT NULL,
   prenom VARCHAR(255) NOT NULL,
   mail VARCHAR(255) NOT NULL,
   password VARCHAR(255) NOT NULL,
   telephone INTEGER NOT NULL,
   PRIMARY KEY(id_utilisateur)
);

CREATE TABLE client(
   id_client INTEGER,
   societe VARCHAR(255) NOT NULL,
   PRIMARY KEY(id_client),
   FOREIGN KEY(id_client) REFERENCES utilisateur(id_utilisateur)
);

CREATE TABLE formateur(
   id_formateur SMALLINT,
   linkedin VARCHAR(255) NOT NULL,
   cv bytea NOT NULL,
   date_signature DATE NOT NULL,
   PRIMARY KEY(id_formateur),
   FOREIGN KEY(id_formateur) REFERENCES Utilisateur(id_utilisateur)
);

CREATE TABLE moderateur(
   id_moderateur SMALLINT,
   PRIMARY KEY(id_moderateur),
   FOREIGN KEY(id_moderateur) REFERENCES Formateur(id_formateur)
);

CREATE TABLE admin(
   id_admin SMALLINT,
   PRIMARY KEY(id_admin),
   FOREIGN KEY(id_admin) REFERENCES formateur(id_formateur)
);

CREATE TABLE discussion(
   id_discussion INTEGER,
   id_client INTEGER NOT NULL,
   id_formateur INTEGER NOT NULL,
   PRIMARY KEY(id_discussion),
   FOREIGN KEY(id_client) REFERENCES client(id_client),
   FOREIGN KEY(id_formateur) REFERENCES formateur(id_formateur)
);

CREATE TABLE message(
   id_message INTEGER,
   id_discussion INTEGER,
   texte VARCHAR(1500),
   date_heure TIMESTAMP NOT NULL,
   valideM BOOLEAN NOT NULL,
   lu BOOLEAN NOT NULL,
   PRIMARY KEY(id_message, id_discussion),
   FOREIGN KEY(id_discussion) REFERENCES discussion(id_discussion)
);

CREATE TABLE activite(
   id_activite SMALLINT,
   nom_activite VARCHAR(100) NOT NULL,
   image VARCHAR(400),
   texte VARCHAR(255),
   PRIMARY KEY(id_activite)
);

CREATE TABLE categorie(
   idC SERIAL,
   nomC VARCHAR(255) NOT NULL,
   valideC BOOLEAN NOT NULL,
   idC_mere SERIAL,
   PRIMARY KEY(idC),
   FOREIGN KEY(idC_mere) REFERENCES categorie(idC)
);

CREATE TABLE theme(
   idT SERIAL,
   nomT VARCHAR NOT NULL,
   valideT BOOLEAN NOT NULL,
   idC SERIAL,
   PRIMARY KEY(idT),
   FOREIGN KEY(idC) REFERENCES categorie(idC)
);

CREATE TABLE niveau(
   idN SMALLINT,
   libelle VARCHAR(255) NOT NULL,
   PRIMARY KEY(idN)
);

CREATE TABLE public(
   idP SERIAL,
   libelleP VARCHAR(255) NOT NULL,
   PRIMARY KEY(idP)
);

CREATE TABLE aExpertiseProfessionnelle(
   idN SMALLINT,
   idT SERIAL,
   id_formateur SMALLINT,
   dureeMExperience SMALLINT NOT NULL,
   commentaire_expertise VARCHAR(255),
   PRIMARY KEY(idN, idT, id_formateur),
   FOREIGN KEY(idN) REFERENCES niveau(idN),
   FOREIGN KEY(idT) REFERENCES theme(idT),
   FOREIGN KEY(id_formateur) REFERENCES formateur(id_formateur)

);

CREATE TABLE aExperiencePeda(
   id_formateur SMALLINT,
   idT SERIAL,
   idP SERIAL,
   volumeHMoyenSession SMALLINT NOT NULL,
   nbSessionEffectuee SMALLINT NOT NULL,
   commentaire VARCHAR(255),
   PRIMARY KEY(id_formateur, idT, idP),
   FOREIGN KEY(idP) REFERENCES public(idP),
   FOREIGN KEY(idT) REFERENCES theme(idT),
   FOREIGN KEY(id_formateur) REFERENCES formateur(id_formateur)
);
