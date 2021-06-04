### Kwerendy

Wszystkie operacje najlepiej jest wykonywać za pomocą QueryBuilder zwracając gotowe obiekty ActiveRecord.

```php 
// zwraca pojedynczego klienta o ID 123
// SELECT * FROM `customer` WHERE `id` = 123
$customer = Customer::find()
    ->where(['id' => 123])
    ->one();

// zwraca wszystkich aktywnych klientów posortowanych po ID
// SELECT * FROM `customer` WHERE `status` = 1 ORDER BY `id`
$customers = Customer::find()
    ->where(['status' => Customer::STATUS_ACTIVE])
    ->orderBy('id')
    ->all();

// zwraca liczbę aktywnych klientów
// SELECT COUNT(*) FROM `customer` WHERE `status` = 1
$count = Customer::find()
    ->where(['status' => Customer::STATUS_ACTIVE])
    ->count();

// zwraca wszystkich klientów w tablicy zaindeksowanej wg ID
// SELECT * FROM `customer`
$customers = Customer::find()
    ->indexBy('id')
    ->all();
```


```php
// zwraca pojedynczego klienta o ID 123
// SELECT * FROM `customer` WHERE `id` = 123
$customer = Customer::findOne(123);

// zwraca klientów o ID 100, 101, 123 i 124
// SELECT * FROM `customer` WHERE `id` IN (100, 101, 123, 124)
$customers = Customer::findAll([100, 101, 123, 124]);

// zwraca aktywnego klienta o ID 123
// SELECT * FROM `customer` WHERE `id` = 123 AND `status` = 1
$customer = Customer::findOne([
    'id' => 123,
    'status' => Customer::STATUS_ACTIVE,
]);

// zwraca wszystkich nieaktywnych klientów
// SELECT * FROM `customer` WHERE `status` = 0
$customers = Customer::findAll([
    'status' => Customer::STATUS_INACTIVE,
]);
```

---

#### QueryBuilder - [doc](https://www.yiiframework.com/doc/guide/2.0/pl/db-query-builder)

```php 
$rows = (new \yii\db\Query())
    ->select(['id', 'email'])
    ->from('user')
    ->where(['last_name' => 'Smith'])
    ->limit(10)
    ->all();
```

---

#### Klasyczne zapytania z zapytaniem sql

```php 
// return a set of rows. each row is an associative array of column names and values.
// an empty array is returned if the query returned no results
$posts = Yii::$app->db->createCommand('SELECT * FROM post')
            ->queryAll();

// return a single row (the first row)
// false is returned if the query has no result
$post = Yii::$app->db->createCommand('SELECT * FROM post WHERE id=1')
           ->queryOne();

// return a single column (the first column)
// an empty array is returned if the query returned no results
$titles = Yii::$app->db->createCommand('SELECT title FROM post')
             ->queryColumn();

// return a scalar value
// false is returned if the query has no result
$count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM post')
             ->queryScalar();
```

--- 

#### Pobieranie danych jako tablice

Do pobrania danych jako tablicę warto użyć `asArray()`. Jest to bardzo optymalne rozwiązanie przy dużej ilości danych.

#### Seryjne pobieranie danych

Przy pobieraniu dużej ilości danych warto używać `each()`.

```php 
// pobiera dziesięciu klientów na raz
foreach (Customer::find()->batch(10) as $customers) {
    // $customers jest tablicą dziesięciu lub mniej obiektów Customer
}

// pobiera dziesięciu klientów na raz i iteruje po nich pojedynczo
foreach (Customer::find()->each(10) as $customer) {
    // $customer jest obiektem Customer
}

// kwerenda seryjna z gorliwym ładowaniem
foreach (Customer::find()->with('orders')->each() as $customer) {
    // $customer jest obiektem Customer
}
```