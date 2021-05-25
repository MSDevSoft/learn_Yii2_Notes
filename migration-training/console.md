### Konsola Yii

Tworzę nową migrację php.
```
yii migrate/create create_news_table
```

---

Uruchamiam migracje. 
```
yii migrate
```

---

Uruchamiam konkretną migrację.
```
yii migrate/to 150101_185401                      # używając znacznika czasu z nazwy migracji
yii migrate/to "2015-01-01 18:54:01"              # używając łańcucha znaków, który może być sparsowany przez strtotime()
yii migrate/to m150101_185401_create_news_table   # używając pełnej nazwy
yii migrate/to 1392853618                         # używając UNIXowego znacznika czasu
```

---

Cofanie migracji
```
yii migrate/down     # cofa ostatnio dodaną migrację
yii migrate/down 3   # cofa 3 ostatnio dodane migracje
```

---

Ponawianie migracji - najpierw down, a potem up
``` 
yii migrate/redo        # ponawia ostatnio zastosowaną migrację
yii migrate/redo 3      # ponawia ostatnie 3 zastosowane migracje
```

---

Recreate całej bazy danych
```
yii migrate/fresh       # czyści bazę danych i wykonuje wszystkie migracje od początku
```

---

Listowanie migracji w konsoli
``` 
yii migrate/history     # pokazuje ostatnie 10 zastosowanych migracji
yii migrate/history 5   # pokazuje ostatnie 5 zastosowanych migracji
yii migrate/history all # pokazuje wszystkie zastosowane migracje

yii migrate/new         # pokazuje pierwsze 10 nowych migracji
yii migrate/new 5       # pokazuje pierwsze 5 nowych migracji
yii migrate/new all     # pokazuje wszystkie nowe migracje
```

---

Oznaczenie wykonanej migracji bez uruchamiania jej
``` 
yii migrate/mark 150101_185401                      # używając znacznika czasu z nazwy migracji
yii migrate/mark "2015-01-01 18:54:01"              # używając łańcucha znaków, który może być sparsowany przez strtotime()
yii migrate/mark m150101_185401_create_news_table   # używając pełnej nazwy
yii migrate/mark 1392853618                         # używając UNIXowego znacznika czasu
```

---

### Konfiguracja różnych poziomów migracji
Można utworzyć różne poziomy migracji np.:
``` 
yii migrate-app
yii migrate-module
yii migrate-rbac
```
A konfigurujemy to w ten sposób:

- Basic: console.php
- Advanced: console/config/main.php 

```php 
return [
    'controllerMap' => [
        // Wspólne migracje dla całej aplikacji
        'migrate-app' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['app\migrations'],
            'migrationTable' => 'migration_app',
            'migrationPath' => null,
        ],
        // Migracje dla konkretnego modułu
        'migrate-module' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => ['module\migrations'],
            'migrationTable' => 'migration_module',
            'migrationPath' => null,
        ],
        // Migrations dla konkretnego rozszerzenia
        'migrate-rbac' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => '@yii/rbac/migrations',
            'migrationTable' => 'migration_rbac',
        ],
    ],
];
```

---

Migrowanie dla wielu baz danych musi być poprzedzone w metodzie init w migracji.
```php 
use yii\db\Migration;

class m150101_185401_create_news_table extends Migration
{
    public function init()
    {
        $this->db = 'db2';
        parent::init();
    }
}
```

--- 
