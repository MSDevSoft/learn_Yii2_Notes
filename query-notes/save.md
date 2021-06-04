## Aktualizacja i zapis danych 

Dane najlepiej zapisywać przez ActiveRecord

```php 
// dodaj nowy wiersz danych
$customer = new Customer();
$customer->name = 'James';
$customer->email = 'james@example.com';
$customer->save();

// zaktualizuj istniejący wiersz danych
$customer = Customer::findOne(123);
$customer->email = 'james@newexample.com';
$customer->save();
```

Warte uwagi jest możliwość manipulacji validacją i zapisem:
```php 
/** @var $runValidation flaga oznaczająca czy przed zapisem ma ruszyć validator sprawdzający dane */
/** @var $attributeNames tablica atrubutów, które mają zostać zapisane do bazy; kiedy null to zostaną zapisane wszystkie  */
$model->save($runValidation = true, $attributeNames = null)
```

---

## Eventy wspomagające i cykle

W modelu można nadpisać metody eventów jeżeli chcemy coś jeszcze zmieniać przed lub po zapisie obiektu.

```php 
public function beforeSave($insert)
{
    if (!parent::beforeSave($insert)) {
        return false;
    }

    // ...custom code here...
    return true;
}
```

--- 

### Cykl życia nowej instancji
Podczas tworzenia nowej instancji Active Record za pomocą operatora new, zachodzi następujący cykl:

1. Konstruktor klasy.
2. init(): uruchamia event EVENT_INIT.

---

### Cykl życia przy pobieraniu danych
Podczas pobierania danych za pomocą jednej z metod kwerendy, każdy świeżo wypełniony obiekt Active Record przechodzi następujący cykl:

1. Konstruktor klasy.
2. init(): uruchamia event EVENT_INIT.
3. afterFind(): uruchamia event EVENT_AFTER_FIND.

--- 

### Cykl życia przy zapisywaniu danych
Podczas wywołania save(), w celu dodania lub uaktualnienia danych instancji Active Record, zachodzi następujący cykl:

1. beforeValidate(): uruchamia event EVENT_BEFORE_VALIDATE. Jeśli metoda zwróci false lub właściwość isValid ma wartość false, kolejne kroki są pomijane.
2. Proces walidacji danych. Jeśli proces zakończy się niepowodzeniem, kolejne kroki po kroku 3. są pomijane.
3. afterValidate(): uruchamia event EVENT_AFTER_VALIDATE.
4. beforeSave(): uruchamia event EVENT_BEFORE_INSERT lub EVENT_BEFORE_UPDATE. Jeśli metoda zwróci false lub właściwość isValid ma wartość false, kolejne kroki są pomijane.
5. Proces właściwego dodawania lub aktulizowania danych.
6. afterSave(): uruchamia event EVENT_AFTER_INSERT lub EVENT_AFTER_UPDATE.

---

### Cykl życia przy usuwaniu danych
Podczas wywołania delete(), w celu usunięcia danych instancji Active Record, zachodzi następujący cykl:

1. beforeDelete(): uruchamia event EVENT_BEFORE_DELETE. Jeśli metoda zwróci false lub właściwość isValid ma wartość false, kolejne kroki są pomijane.
2. Proces właściwego usuwania danych.
3. afterDelete(): uruchamia event EVENT_AFTER_DELETE.