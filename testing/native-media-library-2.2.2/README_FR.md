# Bibliothèque média native — Préversion 1 pour Geeklog 2.2.2

Cette **préversion communautaire** permet de tester la nouvelle bibliothèque média
native sur un site Geeklog 2.2.2, sans attendre Geeklog 2.2.3.

Il ne s'agit **pas** d'une version officielle de Geeklog. Le paquet est
**réservé aux administrateurs**. Il ne modifie ni `lib-common.php`, ni la
base de données, ni les fichiers médias existants.

## Prérequis

- Geeklog **2.2.2**.
- PHP **5.6.4 minimum** (PHP 5.6.40 testé sur un site réel), avec extensions
  **GD** (PNG) et **Fileinfo**.
- Terminal SSH avec Bash, `php`, `curl` facultatif, et `unzip`.
- Sauvegarde indépendante des fichiers **et** de la base de données.
- Essai préalable sur une copie du site fortement recommandé.

**Sécurité :** PHP 5.6 n'est plus maintenu. Cette préversion ne corrige
pas les vulnérabilités de PHP ou d'autres composants Geeklog.

## Téléchargement

Récupérez **un seul ZIP d'installation** dans les ressources de la préversion
GitHub du dépôt `hostellerie/geeklog-2.2.2` :

`geeklog-2.2.2-native-media-library-preview-1.zip`

L'archive GitHub « Source code » n'est **pas** le bon paquet :
elle contient tout Geeklog et n'est pas destinée à être installée par-dessus
un site existant.

## Installation via SSH

1. Placez le ZIP dans votre répertoire personnel (en dehors du site public).
2. Décompressez-le, puis entrez dans son dossier :

```bash
cd ~
unzip geeklog-2.2.2-native-media-library-preview-1.zip
cd geeklog-2.2.2-native-media-library-preview-1
```

3. Identifiez vos deux chemins :
   - `WEB` : dossier contenant `lib-common.php`, `siteconfig.php` et `filemanager/`.
   - `SYS` : dossier Geeklog contenant `classes/`.

Exemple — **à adapter à votre hébergement** :

```bash
WEB="/home/moncompte/public_html"
SYS="/home/moncompte/system"
php -v
bash install.sh --check "$WEB" "$SYS"
```

Le contrôle doit indiquer `Preflight passed. No files modified.`
Vérifiez également le PHP du **site web**, qui peut être différent de celui
de la ligne de commande. **Ne poursuivez pas si le contrôle échoue.**

4. Une fois le site sauvegardé et les prérequis vérifiés :

```bash
bash install.sh --install "$WEB" "$SYS"
```

L'installation sauvegarde automatiquement les fichiers remplacés et retire
les anciens points d'entrée exécutables de Filemanager. Elle ne touche pas
aux images et dossiers utilisateurs.

5. Ouvrez, avec un compte administrateur :

`https://votre-domaine.example/filemanager/index.php?Type=Root`

Rechargez la page avec `Ctrl + Maj + R`.

## Tests recommandés

1. Afficher les dossiers et les miniatures.
2. Téléverser une petite image JPEG ou PNG.
3. Créer, renommer et supprimer un **dossier vide** : une confirmation doit
   toujours apparaître avant sa suppression.
4. Recadrer, pivoter, redimensionner une image ; enregistrer une copie.
5. Insérer une image dans un article via CKEditor.
6. Confirmer qu'un utilisateur non administrateur n'accède pas à la bibliothèque
   ni à son API.
7. Parcourir un dossier contenant de nombreuses images : les miniatures
   doivent se charger progressivement, avec au maximum deux chargements
   simultanés.

## Retour arrière

Conservez impérativement le chemin de sauvegarde affiché à l'installation.
La commande de retour arrière est :

```bash
bash "/CHEMIN/SAUVEGARDE/rollback.sh" "/CHEMIN/SAUVEGARDE"
```

Saisissez `RESTORE` pour confirmer. Cette opération restaure les anciens
fichiers du gestionnaire ; elle **ne supprime pas** les médias téléversés
pendant les tests.

## Jusqu'à Geeklog 2.2.3

Vous pouvez conserver cette préversion tant que le fonctionnement reste
satisfaisant. Gardez la sauvegarde et sauvegardez régulièrement les médias.
Lors du passage à Geeklog 2.2.3, **ne restaurez pas l'ancien gestionnaire
avant la mise à jour**. Vérifiez d'abord que la version officielle inclut
la nouvelle bibliothèque et suivez ses instructions de migration.

## Retours et anomalies

Signalez le navigateur, la version PHP du site, la version Geeklog, les étapes
de reproduction et les erreurs pertinentes (sans cookies ni données privées) :
https://github.com/Geeklog-Core/geeklog/pull/1173

Pour la procédure détaillée en anglais : `README.md`.
