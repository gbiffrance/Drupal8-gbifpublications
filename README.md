GBIF Publications
=================

Affichage des publications faite sur le réseau GBIF pour Drupal 8.

Instructions
------------

1. Dézipper l'archive dans le dossier *modules/custom* de votre installation Drupal. Activez-le ensuite dans l'interface graphique sur la page d'administration des modules (`[URL_de_votre_page_d_accueil]/admin/modules`).

2. Générer le fichier qui contiendra les publications en visitant la page suivante : `[URL_de_votre_page_d_accueil]/gbifpublications/generate/{country}` ; `{country}` étant le code en 2 lettres du pays voulu.

3. Pour voir les publications, visitez la page `[URL_of_Drupal]/gbifpublications/display/{country}`

---

Un bloc qui met à jour les publications contenu dans le fichier de données est également disponible.

Si vous avez besoin des informations pour d'autre modules, vous avez besoin de la permission *generate GBIF Publications*.

Attention
---------

Ce module est en cours de travail. Reportez tout bugs et suggestions.

---
---

GBIF Publications
=================

GBIF Publications displayer for Drupal 8.

Instructions
------------

1. Unpack the archive in the *modules/custom* folder (currently in the root of your Drupal 8 installation) and enable it in the administrative module page (`[URL_of_home_page]/admin/modules`).

2. Visit `[URL_of_home_page]/gbifpublications/generate/{country}` to generate the file who contains the publication about the country;`{country}` is the two-letter country code.

3. Visit `[URL_of_Drupal]/gbifpublications/display/{country}` to see your page displaying the publication.

---

There is also a generator block by the module to update the file who contains the publication

If you need the information for other modules, be advice than you will need *generate GBIF Publications* permission.

Attention
---------

This module is a work in progress. Please report bugs and suggestions.