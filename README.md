# validator

Systeme de validation de donnees

## Installation

```
composer require fzed51/validator
```

## Utilisation

### Constructeur

```php
use Fzed51\Validator\Validator;
$v = new Validator($data);
```

Passer en paramètre du constructeur les données à valider. `$data` peut être un tableau ou un objet.

### getErrors

Retourne un tableau d'érreurs

### isValide

Retourne un bouléen indiquant si la validation c'est bien passé.

### required

```php
$v->required('nom','prenom');
```

Vérifie que les données nom et prenom sont présentes.

### notEmpty

```php
$v->notEmpty('nom','prenom');
```

Vérifie que les données nom et prenom sont présent et non vide.

### slug

```php
$v->slug('slug');
```

Vérifie que la donnée slug est bien un slug. C'est à dire une chaine contenant des a à z, A à Z, 0 à 9 et - avec 2 - ne pouvant pas se suivre.

### betweenLength

```php
$v->betweenLength(4, 64, 'login', 'nom');
```

Vérifie que les données age et nom sont >= 4 caractères et <= 64 caractères.

### maxLength

```php
$v->maxLength(1024, 'comment');
```

vérifie que la donnée comment est <= 1024 caractères.


### minLength

```php
$v->minLength(8, 'pass');
```

vérifie que la donnée pass est >= 8 caractères.

### dateTime

```php
$v->dateTime('debut', 'fin');
```
Vérifie que les données debut et fin sont bien des instant au format 'AAAAMMJJ HHMMSS'

### date

```php
$v->dateTime('anniv');
```
Vérifie que la donnée aniv est bien une date au format 'AAAAMMJJ'
