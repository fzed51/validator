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
$v->required('nom','prenom')
```

Vérifie que la donnée nom et prenom sont présente.
