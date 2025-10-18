Bienvenue sur le projet de création de logiciel de suivi de colis pour l'IUT de Villetaneuse, Sorbonne Paris-Nord !  

# Équipe
- **@weame959**
- **@D4CJ**
- **@ysmn-a**
- **@Myriam**
- **@Mégane**
- **@Nostres25** (**auteur de ce document**)

Le demandeur du projet est l'enseignant chercheur et responsable du département CRIT à l'IUTV, **Franck Butelle**.

# Développement
## Git
Tout d'abord le repository GitHub est là pour héberger le code en ligne afin d'éviter les pertes de progression et de faciliter le travail en équipe.  
GitHub s'utilise avec **le logiciel [Git](https://git-scm.com/) qu'il vous faut installer** pour travailler sur le développement. C'est ce logiciel qui vous permettra de récupérer le code du projet mais aussi de publier vos modifications.  
La plupart des IDE (ou éditeurs de code) comme Visual Studio Code embarquent des menus pour interagir avec git via l'interface, afin d'appuyer sur des boutons plutôt que de rédiger des commandes git. Mais ce document s'appuie sur les commandes git.   
###### [GitHub Desktop](https://desktop.github.com/download/) existe pour interagir avec git avec une interface mais c'est aussi plutôt limité et inutile si l'IDE comprend des menus git.

## Environnement
Technologies: PHP, **MariaDB**, Apache2, Linux (le serveur de production sera sur Ubunutu) --> [XAMP](https://www.apachefriends.org/fr/index.html) pour permettre un développement sur linux et sur windows.
Framework: (Laravel ?)  
Un site web PHP implique un serveur web supportant le PHP. Car le PHP n'est pas exécuté par le navigateur comme le HTML/CSS/Javascript, il s'exécute sur le serveur. Ainsi, vous devez installer php, mariadb et apache2 sur votre système et le configurer de sorte à ce que php fonctionne sur le serveur apache2 et puisse utiliser une base de données mariaDB.

## Code
Formatteur: <inconnu> (permet de respecter un style de programmation commun)

> [!NOTE]
> Vous pouvez mettre le dossier du projet où vous souhaitez sur votre ordinateur

## Introduction à git
Tout d'abord assurez vous de bien avoir le logiciel Git d'installé [(lien d'installation)](https://git-scm.com/downloads). 
Pour commencer, on parlera de **git** quand on veut parler de l'outil qui permet de gérer un **dépot local**[^1]. Alors que **github** est l'outil en ligne qui nous permet d'héberger le code en ligne, c'est-à-dire sur un **dépôt distant**[^2].
Pour en savoir plus sur le fonctionnement de git et de github, et notamment comprendre la notion de dépôts, [cliquez ici](https://comprendre-git.com/fr/glossaire/git-depot-distant-et-local/).

#### Utiliser git sur Windows:
Je vous conseil d'utiliser l'invite de commandes git, disponible avec un clique droit sur un dossier, en appuyant sur "Plus d'options" si vous êtes sur windows 11 et en cliquant sur "**Git Bash Here**". Cet invite de commandes permet d'utiliser [la commande `git`](https://git-scm.com/docs/git) pour interagir avec git et github. Mais il apporte aussi d'autres commandes comme `cd` pour changer de dossier et [`nano`](https://nano-editor.org/dist/v2.2/nano.html) pour modifier un fichier directement dans le terminal et autre (un peu comme sur linux).
> [!WARNING]
>  **Il est toutefois très conseillé de développer sur linux directement ou avec un WSL** car le serveur de production sera un serveur linux (Ubuntu, plus précisément) et il y a des différences, notamment avec les chemins de fichiers entre Windows et Linux  

Pour exécuter des commandes git vous devrez tout le temps passer par cet invite de commande git (Git bash) **et dans le bon dossier**.

#### Utiliser git sur Linux
Vous pouvez utiliser la commande `git` dans le terminal classique

#### Utiliser git sur Mac
Aucune idée. Bon courage ! :) *ça doit être proche de linux je suppose ?*

## Importer le projet
Avant tout, le dossier du projet n'a pas été crée. Il vous faut d'abord importer le projet. 
1. Pour cela, placez-vous dans le dossier dans lequel vous souhaitez placer le projet, et ouvrez l'invite de commandes. (l'invite de commandes git ou "Git bash" sur windows)
> [!TIP]
> Vous pouvez utiliser la commande `cd` dans l'invite de commande pour vous déplacer de dossier

2. Ensuite clonez le code du projet à l'aide de la commande :
```
git clone https://github.com/Nostres25/suivis-colis-iutv.git
```
> [!NOTE]
> la première fois, il vous sera demandé de vous connecter. Si vous n'êtes pas redirigé vers une interface pour entrer vos identifiants github, vous devrez [créer un token d'accès personnel](https://docs.github.com/fr/authentication/keeping-your-account-and-data-secure/managing-your-personal-access-tokens) pour l'entrer à la place du mot de passe.

Maintenant vous pouvez ouvrir **le dossier su projet**, crée sous le nom de "suivis-colis-iutv", dans votre IDE favori  ! ✅
> [!WARNING]
> Toutefois, attention à ne rien modifier à cette étape. Car vous êtes sur la branche `main` du projet et que si vous modifiez quoi que ce soit, vous pouvez créer des conflits sur cette branche. **Prenez connaissance de la suite de cette documentation avant de faire quoi que ce soit**.

## Travailler avec git
Étant donné que nous sommes plusieurs à travailler sur ce projet et qu'il n'y a pas de synchronisation automatique entre le dépôt local[^1] et le dépôt distant[^2], l'un d'entre nous pourrait avoir des modifications en cours pendant que vous travaillez sur le projet. Et ces modifications peuvent porter sur le même fichier voir le même bout de code. Ce qui peut causer des conflits car vous avanceriez sur un projet non à jour et lorsque vous souhaiterez publier vos modifications, git ne saura pas choisir quelle modification est bonne à garder car les deux modifications sont incompatibles.
Pour éviter ce genre de complications, nous devons respecter une organisation stricte. Voici un résumé des règles ci-dessous.

### Résumé des règles du développement du projet
Si vous n'êtes pas familier avec les termes employés dans les consignes ci-dessous, accédez à la suite et lisez le règlement une fois que vous aurez compris comment git fonctionne. Le non respect de ces règles nous risque à de la perte de travaille et de la perte de temps. \
[--> [Accéder à la suite]](#etat-du-d%C3%A9p%C3%B4t-local)

#### 1. Ne jamais modifier la branche[^4] `main`
> Pour développer une nouvelle fonctionnalité, corriger un bug ou autre, vous devez [créer une nouvelle branche](#cr%C3%A9ation-dune-branche) au nom de la fonctionnalité, du bug ou autre. (exemple: "creation_dao" ou "fix_echappement"). La branche main doit être composée uniquement de commits/modifications vérifiées (via pull requests).

#### 2. Ne jamais avancer sur une branche non à jour (dont on n'a pas les dernières modifications, publiées ou non)
> Avant de commencer à travailler sur une branche, assurez vous que toute personne travaillant sur cette branche ait publié toutes ses modifications pour ensuite exécuter [`git pull`](#pull) **depuis la branche en question** afin de mettre à jour votre dépôt local et travailler dessus.

#### 3. Ne jamais modifier la branche de quelqu'un d'autre sans prévenir
> Cette règle rejoint la règle du dessus. Utilisez le serveur Discord du projet pour prévenir publiquement, dans le salon relatif au code que vous comptez apporter une modification sur une branche déjà prise en charge. Il vous faut d'abord vous assurer que toutes les modifications de cette branche aient été publiées, et exécuter un [`git pull`](#pull) depuis la branche pour importer tous les commits. La personne qui prenait en charge la branche auparavant ne doit par conséquent plus apporter de modification sur cette branche avant que vous ayez fini.

#### 4. Ne jamais apporter de modification sur une fonctionnalité ou sur un fichier pour lequel des modifications sont en cours par quelqu'un d'autre
> Même si ce fichier ou cette fonctionnalité est modifiée depuis une autre branche, cela n'a pas de sens de la modifier ailleurs. C'est donc à la personne qui a prise en charge la modification de cette fonctionnalité qui doit apporter les modifications que vous vous apprétiez à faire. Sauf si vous prenez en charge la branche en question, dans ce cas c'est la règle ci-dessus qui s'applique. \
> Dans de rares cas il peut être nécéssaire de modifier un fichier ou une fonctionnalité dont une modification est en cours dans une autre branche. Mais dans tous les cas, il faudra en discuter avec la personne qui travaille sur le fichier ou la fonctionnalité. Et le conflit potentiel devra être géré lors du merge.

#### 5. Toujours pull[^5] avant de commencer une modification sur une branche
> Pour éviter tout problème (conflits), assurez-vous de faire un [`git pull`](#pull) avant d'entamner la moindre modification sur une branche. `git status` vous permet de voir si votre branche est à jour de manière fiable uniquement si un `git fetch` a été effectué au préalable.

#### 6. Commit[^3] à chaque modification. C'est-à-dire à chaque version stable du code
> Évitez de commit des modifications avec lesquelles il y a des erreurs. Le code doit fonctionner parfaitement à chaque commit. En général : 1 correction/1 ajout/1 modification = 1 commit 

#### 7. À la fin de votre session de travail, vous devez push[^6] tous vos commits
> Ne gardez pas des commits non publiés sur votre ordinateur. Sinon, les modifications apportées peuvent être perdues si vous avez un problème avec votre ordinateur (corruption ou autre incident), mais aussi nous ne pourrons pas suivre votre avancement pour savoir quelles modifications vous avez déjà apportées. Ce qui ralentirait le développement. C'est pour cela que vous devez exécuter [`git push`](#push) pour publier tous vos commits à chaque fin de session de travaille ou à chaque fin de journée.

#### 8. Ne jamais merge[^7] directement, mais créer un pull request[^8] à la place
Pour s'assurer que les merges sont correct et donc éviter des pertes de travaille ou l'introduction de bugs, ne faites pas de merge directement si vous n'êtes pas sûr de ce que vous faites. Il faudra [créer un pull request](#pull-requests-et-merges) à la place.

#### 9. Vous devez créer un pull request une fois que vous avez terminé votre travail sur une branche.
> Vous n'avez pas la permission de merge pour éviter tout problème. À la place, vous devez [créer un pull request](#pull-requests-et-merges) via l'interface GitHub (onglet Pull Request). Ce qui est une "demande de pull" ou plutôt une "demande de merge", et @Nostres25 s'occupera de vérifier les modifications et confirmer le merge si tout est correct. Sans cela, votre travail ne sera jamais intégré au reste du projet. 

#### 10. Toujours créer un pull request pour merge la branche à partir de laquelle on a créé notre branche
> Il est possible de créer une branche à partir de n'importe quelle branche. Mais si vous créez une branche "fix_actions_rapides" à partir de "actions_rapides" mais que vous souhaitez merge "fix_actions_rapides" sur "main", votre modification et les anciennes modifications de "actions_rapides" serront publiées sur la branche principale alors que les modifications dans "actions_rapides" ne sont probablement pas terminées. Il faut donc procéder étape par étape et créer un pull request pour merge "fix_actions_rapides" sur "actions_rapides" puis plus tard "actions_rapides" sur "main". Évidemment les pull request sont à créer une fois les modifications sur la branche, terminées.

### Etat du dépôt local
Pour éviter de faire des erreurs, il faut déjà savoir où nous sommes, et qu'avons nous fait à présent. Si nous ne pouvons pas répondre à ces interrogations, alors il est risqué d'aller plus loin.
Pour remédier à cela, il existe la commande :
```
git status
```
Cette commande affiche l'état du dépôt local, c'est-à-dire :
- la branche actuelle
- les fichiers modifiés, non ajoutés pour le prochain commit
- les fichiers modifiés, ajoutés au prochain commit
- s'il y a des commits non publiés
- si la branche actuelle est à jour (il vaut mieux faire `git fetch` avant pour s'assurer que l'information est bien actualisée)
- les fichiers avec des conflits s'il y en a

> [!TIP]
> je vous invite à souvent utiliser `git status` pour vous repérer. C'est-à-dire pour savoir dans quelle branche vous êtes, si votre branche est à jour, si vous avez des modifications non commit et si vous avez des commits non publiés. Il est très important de savoir tout cela pour ne pas modifier la mauvaise branche, ou créer des conflits.


### Au sujet des branches[^4]
Si vous avez suivi [le tuto pour importer le projet](#importer-le-projet) sur votre ordinateur, vous avez cloné la branche principale (main) du repository.

> [!CAUTION]
> - **Evitez un maximum de travailler sur la branche principale ! Et si vous avez des difficultés ou que vous pensez avoir fait une erreur, ne faites rien sans certitude de ce que vous faites. Appelez @Nostres25 avant de continuer**.
> - Les fichiers actuellement dans le dossier du projet sur votre ordinateur correspondent aux fichiers du dépôt local **de la branche active**. Cela signifie que ces fichiers sont potentiellement pas à jour (d'où les précautions données précédemment). Ainsi que changer de branche correspond en réalité à tout supprimer du dossier du projet (sauf .git/) pour remettre tous les fichiers conformément à la nouvelle branche sélectionnée. Alors, les modifications non commit seront perdues au changement de branche mais les commits non publiés, comme publiés, de l'ancienne branche seront bien conservés grâce au répertoire `.git`.

#### Création d'une branche
Si vous voulez travailler sur une fonctionnalité, un ajout ou une correction en particulier (base de données, dao, historique des commandes...), vous devez créer une nouvelle branche.
Pour se faire, rendez-vous dans le dossier du projet depuis l'invite de commandes git.
Puis, créez une nouvelle branche avec la commande :
```
git branch <nom_de_la_branche> <branche_de_départ>
```

> [!NOTE]
> - La nouvelle branche créée reprendra la code de la "branche_de_départ". **Donc si vous n'avez encore rien commencé et que vous allez commencer une nouvelle fonctionnalité, mettez le nom de la foncitonnalité en nom de branche (le plus concis possible) et "main" en branche de départ (la plus part du temps)**
> - Si vous vérifiez avec `git status`, vous verrez que vous n'avez pas automatiquement basculé sur la nouvelle branche. Pour cela il existe [une autre commande](#changer-de-branche).

> [!TIP]
> Sinon, vous pouvez utiliser la commande suivante pour créer une nouvelle branche **et basculer dessus automatiquement** :
> ```
> git checkout -b <nouvelle_branche> <branche_de_depart>
> ```

#### Changer de branche
Pour afficher et/ou modifier le contenu d'une branche, vous devez accéder/charger le contenu de cette branche. Car le contenu du dossier du projet correspond uniquement à l'état du projet tel qu'il l'est **dans une seule branche**.

Alors pour changer de branche, exécutez :
```
git checkout <nom_de_la_branche>
```

### Pull
> [!NOTE]
> Avant d'avancer sur une branche déjà existante, il se peut que des modifications aient été faites sur cette branche et que vous n'avez pas la dernière version du code.
> Alors, avant de commencer à travailler sur une branche, pensez à pull[^5] avec :
```
git pull
```
Pour mettre à jour le code de la branche actuelle sur votre pc.

### Ajouter des fichiers pour le prochain commit
Une fois avoir fait une modification précise (correction d'un certain bug, ajout ou amélioration d'une certaine fonctionnalité), pensez à exécuter :
```
git add <fichier/dossier>
```
Pour ajouter les fichiers modifiés au commit.
> [!NOTE]
> - Vous pouvez faire `git add *` pour ajouter tous les fichiers modifiés au commit d'un coup
> - Vous devrez refaire `git add` si vous re-modifiez un fichier, même avant de l'avoir commit.

### Commit
Pour commit[^3] tous les fichiers "ajoutés" avec `git add`, exécutez:
```
git commit -m "<message>"
```
> [!NOTE]
> - Un commit correspond à une modification dans le code. Vous devez vous assurer de commit à chaque version stable de votre code, c'est-à-dire sans erreur.
> - Vous pouvez créer plusieurs commits que vous pourrez [push](#push) en même temps
> - Et à la place de `<message>`, vous devez décrire le commit (le changement) de la manière la plus conçise possible tout en restant précis



### Push
Enfin, quand vous voulez publier/push[^6] vos commits (c'est-à-dire vos modifications) effectuées sur la branche actuelle, sur github, faites:
```
git push 
```
> [!WARNING]
> Si vous ne pouvez pas [push](#push) vos commits car votre branche n’est pas à jour, vous devez [pull](#pull) d’abord. Ensuite, il est possible que cela engendre des conflits. Vous devrez les régler vous même ou faire appel à @Nostres25 si vous ne savez pas comment faire.

### Pull Requests et merges
> [!NOTE]
> - Un merge[^7] est une fusion du code de deux branches. Par exemple: Soan a terminé le système d'actions rapides, il veut le fusionner à la branche principale (main). Il va falloir merge le code de la branche "actions_rapides" au code de la branche "main".
> - Alors qu'un pull request[^8] c'est une demandé de merge par github. Qui devra être vérifiée et validée avant d’effectuer le merge

> [!NOTE]
> Un merge mal fait peut engendrer des pertes de progression et/ou rendre le code non fonctionnel à causes des conflits qui peuvent survenir durant le merge. En effet, la fusion de deux code provoque la suppression, modification ou l'écrasement de lignes de code (ou fichier) en masse sur une branche. Alors, lors d'un merge avec des conflits, il faudra manuellement décider de ce qu'il faut garder, supprimer ou écraser.
>
> La rédaction de cette documentation et l'organisation associée pour le développement du projet permet justement d'éviter un maximum les conflits.

Alors, lorsque vous voulez merge votre branche, c'est-à-dire fusionner le code de votre branche avec sa branche de départ:
1. Rendez-vous sur le [projet GitHub en ligne à la page Pull Request](https://github.com/Nostres25/HeartOfStellars/pulls)
2. Faites "New pull request"
3. Sélectionnez la branche dans laquelle vous voulez fusionner votre code à gauche
4. Puis sélectionnez la branche que vous voulez fusionner à droite
5. Ensuite vous pourrez appuyer sur "Create Pull Request"
6. Et attendre que @Nostres25 s'occupe du merge.

### Risques de travailler à plusieurs sur une même branche
Il peut être possible de travailler à plusieurs sur une même branche mais il faut respecter certaines règles pour éviter des conflits :
- Si vous voulez avancer sur une branche alors que quelqu'un y travaille déjà, et donc a potentiellement du code/des commits non publié, créez une autre branche à partir de celle que vous voulez modifier. Lorsque vous aurez terminé avec cette nouvelle branche, vous pourrez faire un [Pull Request](https://github.com/Nostres25/HeartOfStellars/pulls) pour fusionner avec la branche de départ (à ne pas confondre avec la branche principale). **Et communiquez pour ne pas apporter les mêmes modifications ou des modifications contradictoires**
- Cependant si la personne qui s'occupe de cette branche a terminé, n'a plus de modification/de commit non publié et ne va pas continuer sur cette branche avant la fin de vos modifications, alors vous pouvez continuer le travail sur cette branche sans en créer une nouvelle. (⚠️ en vous assurant bien d'être sur la bonne branche et de [`git pull`](#pull) avant)


[--> [Revenir aux règles du développement du projet]](#r%C3%A9sum%C3%A9-des-r%C3%A8gles-du-d%C3%A9veloppement-du-projet)

### Autre

- De même, vous le voyez quand vous tappez juste la commande `git` dans votre invite de commande mais il y a beaucoup de commandes git et de possibilités avec celles-ci. Cette documentation vous apprend les bases mais vous pourrez toujours avoir besoin de faire des recherches internet, de demander à un membre de l'équipe de développement ou de vérifier la documentation git pour effectuer dans actions spécifiques dans certains cas (comme annuler une action)

- Ensuite, une autre commande très utile permet de voir les modifications effectuées dans le détail jusqu'aux lignes de codes. La commmande est:
  ```
  git diff
  ```
  Pour plus d'informations sur la commande rendez-vous sur la [documentation git](https://git-scm.com/docs/git-diff).

- Ce n'est pas obligatoire mais de manière conventionnelle, les messages de commits doivent respecter une certaines syntaxe qui peut ressembler à `fix: 🐛 fight system bug fixed`. Et oui, **en anglais**, C'est plus pratique car plus facilement lisible lorsqu'on visionne la progression du projet. [(Plus d'infos sur les conventionnal commits)](https://www.conventionalcommits.org/fr/v1.0.0/)

  Pout ma part, j'utiliserai cette syntaxe de commits conventionnels en anglais. Ce serait mieux que tout le monde fasse de même pour un ensemble cohérent

## Avec Github Desktop
Malheureusement cette partie n'a pas encore été rédigée. Passer par la commande, surtout en suivant cette documentation vous permettra de beaucoup mieux comprendre le fonctionnement de git et de GitHub.
Mais si vous avez compris le fonctionnement de git avec les commandes, Github desktop sera facile à comprendre car chaque action correspond en réalité à une commande git.
Il est vrai que Github desktop offre un meilleur confort avec une interface. Surtout pour l'affichage des différences (équivalent à `git diff`). 

# Programmation
### Habitudes de programmation & conseils
#### Documentations
Aidez-vous de [la documentation PHP]([https://manual.gamemaker.io/monthly/fr/#t=Content.htm](https://www.php.net/docs.php)) et de tutos. Cependant il est fortement déconseillé de copier du code sans comprendre son fonctionnement. Même s'il fonctionne.
###### Évidemment, aidez-vous aussi de la documentation de votre framework si vous en utilisez-un

#### Progrmmation orientée object 
Il vous faut maîtriser la programmation orientée objets avec le principe d'héritage qui est très important.

#### Style de programmation et lisibilité du code
> [!NOTE]
> Avec un formatteur, le style de programmation sera formalisé automatiquement.
- Adaptez votre [style de programmation](https://fr.wikipedia.org/wiki/Style_de_programmation) au projet. En effet, il y a différentes façons de formatter son code, notamment pour la position des accolades, des parenthèses etc... Avoir un style de programmation commun au sein du projet garantira une meilleure lisibilité et une meilleure compréhension du code.
- À propos du formattage du code, veillez à bien espacer (pas trop) les différents éléments de code de sorte à créer des blocs de lignes associées. Il faut qu'on puisse dissocier rapidement les lignes qui n'ont pas de lien direct entre elles. Pour cela, vous pouvez vous inspirer de ce qui est déjà fait dans le projet.

#### Optimisation
- Pensez à utiliser des [fonctions](https://www.php.net/manual/fr/language.functions.php) pour des bouts de codes que vous souhaitez utiliser plusieurs fois, de sorte à ne jamais répéter des blocs de code.
- Une des règles avec les fonctions est : une fonction pour un usage. Si votre fonction possède plusieurs étapes (exemple: le chargement de plusieurs types de données différentes), il est porbablement nécéssaire de faire une fonction pour chaque étape (exemple: une fonction pour le chargement des sauvegardes, une fonction pour le chargement des paramètres etc...).
- Pensez optimisation de la mémoire et des opérations. En effet, votre code doit en priorité comporter le moins d'opérations possibles, en éliminant les répétitions et en stockant des données en mémoire à l'aide de variables. Mais il faut aussi faire attention à ne pas utiliser de mémoire inutilement.

#### Langage: Commentaires & noms
- Pensez clarté. Si un bout de code n'est pas suffisant à lui tout seul pour comprendre son fonctionnement et/ou son utilité (avec la connaissance du langage), alors il faut ajouter des commentaires. Pour expliquer un fonctionnement peu intuitif par exemple. Faites attention à ne pas mettre trop de commentaires, pour par exemple expliquer chaque ligne de code. La plupart du temps le code doit être suffisamment clair pour ne pas avoir besoin de commentaires.
- Langage anglais : les commentaires, les variables, les fonctions, les noms des fichiers, et tout ce qui touche au code doivent être écrits en anglais. Même les commits et les noms des branches de préférence.
- Nom de variables : Le nom des [variables](https://www.php.net/manual/fr/language.variables.php) et des [fonctions](https://www.php.net/manual/fr/language.functions.php) doit décrire clairement la fonction de la variable ou de la méthode. Et, pour suivre la convention, ils s'écrivent en minuscule. Si le nom comporte plusieurs mots, la première lettre des mots suivants est en majuscule (ex: `lastIndex`). Une autre alternative pour les variables est par exemple : `last_index`. Ensuite, les variables constantes sont en majuscule (ex: `VERSION`) et les classes ainsi que les [énumérations]([https://manual.gamemaker.io/monthly/en/GameMaker_Language/GML_Overview/Variables/Constants.htm](https://www.php.net/manual/fr/language.types.enumerations.php)) commencent par une majuscule (ex: `Player` et `Color`). Toutefois, les valeur des énumérations sont en majuscule également (`Color.RED`)

[^1]: Le **dépôt local** correspond à l'enssemble du projet tel qu'il est sauvegardé localement. C'est-à-dire sur votre appareil. Le dépôt local comprend l'ensemble des branches avec l'ensemble des commits qui ont été mis à jours depuis le dépôt distant. Le dépôt local ne se met pas à jour automatiquement et il est représenté par un repertoire `.git` dans le dossier du projet.
[^2]: Le **dépôt distant** correspond à l'ensemble du projet tel qu'il est en ligne, sur github.com. Il comprend l'ensemble des branches et des commits qui ont été publiés via [`git push`](#push). Et c'est à partir de lui que se fait la mise à jour du dépôt local via [`git pull`](#pull).
[^3]: Un **commit** est une modification dans le code accompagnée d'un court message de description et d'un identifiant généré automatiquement. Il correspond à UN ajout, à UNE amélioration ou à UNE correction. Dans l'idéal, il faut commit à chaque version stable du code (un commit ne doit pas comporter d'erreur). La commande [`git commit`](#commit) va enregistrer en local les modifications faites dans les fichiers qui ont été ajoutés via `git add` au préalable, pour la branche actuelle.
[^4]: Une **branche** en git correspond à une section dans laquelle le code et l'enssemble des commits qui le définissent sont représentés. La notion de branche vient du fait qu'il peut y avoir plusieurs de ses sections. Ce qui se représente par des branches (d'un arbre) dans la liste des commits. Car la création d'une nouvelle branche se fait obligatoirement à partir d'un commit d'une branche existante (généralement le plus récent). Ainsi, les nouveaux commits sur la nouvelle branche seront différés des commits sur la branche originelle et inversement. Par conséquent, le code aussi. Le noeux est donc le commit de départ de la nouvelle branche sur l'ancienne branche et les branches correspondent à l'ensemble des commits dans ces différentes branches. Pour vérifier dans quelle branche vous êtes, vous pouvez utiliser `git status`.
[^5]: L'action de **pull**, traduite par "tirer" en français correspond à la mise à jour de la branche actuelle à partir de la même branche du dépôt distant. Tous les commits publiés sur le dépôt distant via [`git push`](#push) par autruit seront importés sur le dépôt local
[^6]: L'action de **push**, taduite par "pousser" en français correspond par la publication de tous les commits non publiés de la branche actuelle du dépôt local, vers la même branche du dépôt distant
[^7]: L'action de **merge**, traduite par "fusionner" en français correspond à la mise en commun des commits des deux branches. Autrement dit, une fusion. Cette fusion se fait d'une branche à une autre, comme l'import des nouveaux commits d'une première branche vers une deuxième branche. Et les commits contradictoires entre les branches, c'est-à-dire qui touchent aux mêmes lignes d'un même fichier, feront l'objet d'un conflit. Qui nécéssitera une intervention humaine pour choisir quel commit accepter et quel commit rejeter. La fusion des commits se traduit d'ailleurs par une fusion du code des deux branches.
[^8]: L'action de **pull request**, traduite en français par "demande de tirer", n'a contre toute attente, pas de lien direct avec l'action de pull. Mais plutôt avec l'action de merge. En effet, au lieu de merge directement, créer un pull request permet de publier une demande de merge d'une branche à une autre sur le répertoire github. Cette demande est accompagnée d'un nom, d'une description et d'un fil de commentaires. Cela permet à un autre développeur (@Nostres25 dans le cas actuel), de vérifier le merge demandé et les différents commits dont il est question et de procéder au merge lui-même et gérant les conflits s'il y en a. Pour garder un contrôle sur les modifications apportées au projet et pour notamment éviter aux autres développeurs d'avoir à gérer les conflits.
