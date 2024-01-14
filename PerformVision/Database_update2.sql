DROP TABLE IF EXISTS message, discussion, client, moderateur, admin, aExpertiseProfessionnelle, aExperiencePeda, formateur, activite, image, niveau, theme, categorie, public, utilisateur;

CREATE TABLE utilisateur(
   id_utilisateur SERIAL,
   nom VARCHAR(255) NOT NULL,
   prenom VARCHAR(255) NOT NULL,
   mail VARCHAR(255) NOT NULL,
   password TEXT NOT NULL,
   telephone INTEGER NOT NULL,
   role VARCHAR(50) NOT NULL,
   est_affranchi boolean NOT NULL,
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
   date_signature DATE NOT NULL,
   cv VARCHAR(255) NOT NULL,
   declaration VARCHAR(255) NOT NULL,
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
   id_discussion SERIAL,
   id_client INTEGER NOT NULL,
   id_formateur INTEGER NOT NULL,
   PRIMARY KEY(id_discussion),
   FOREIGN KEY(id_client) REFERENCES client(id_client),
   FOREIGN KEY(id_formateur) REFERENCES formateur(id_formateur)
);

CREATE TABLE message(
   id_message SERIAL,
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
   texte VARCHAR(255),
   PRIMARY KEY(id_activite)
);

CREATE TABLE image(
   id_image SMALLINT,
   id_activite INTEGER,
   chemin_acces_image VARCHAR(255) NOT NULL,
   nom_image VARCHAR(100) NOT NULL,
   taille_image INTEGER NOT NULL,
   type_image VARCHAR(100) NOT NULL,
   bin_image bytea NOT NULL,
   PRIMARY KEY(id_image),
   FOREIGN KEY(id_activite) REFERENCES activite(id_activite)
);

CREATE TABLE categorie(
   idC SERIAL,
   nomC VARCHAR(255) NOT NULL,
   valideC BOOLEAN NOT NULL,
   idC_mere INT NULL,
   PRIMARY KEY(idC),
   FOREIGN KEY(idC_mere) REFERENCES categorie(idC)
);

CREATE TABLE theme(
   idT SERIAL,
   nomT VARCHAR NOT NULL,
   valideT BOOLEAN NOT NULL,
   idC INT NOT NULL,
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
   volumeHMoyenSession TIME NOT NULL,
   nbSessionEffectuee SMALLINT NOT NULL,
   commentaire VARCHAR(255),
   PRIMARY KEY(id_formateur, idT, idP),
   FOREIGN KEY(idP) REFERENCES public(idP),
   FOREIGN KEY(idT) REFERENCES theme(idT),
   FOREIGN KEY(id_formateur) REFERENCES formateur(id_formateur)
);
