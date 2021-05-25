### Pobieranie leniwe i gorliwe

> Domyślnie obiekty mają ładowane paramenty leniwie.

```php 
// SELECT * FROM `customer` WHERE `id` = 123
$customer = Customer::findOne(123);

// SELECT * FROM `order` WHERE `customer_id` = 123
$orders = $customer->orders;

// bez wykonywania zapytania SQL
$orders2 = $customer->orders;
```

### Gorliwe ładowanie

> Jednym zapytaniem pobranie klienta z tablicą zamówień

```php 
$customers = Customer::find()
    ->with('orders')
    ->all();
```

### Zagnieżdżone gorliwe ładowanie

```php 
// gorliwe pobieranie "orders" i zagnieżdżonej relacji "orders.items"
$customers = Customer::find()->with('orders.items')->all();
// uzyskanie dostępu do produktów pierwszego zamówienia pierwszego klienta
// kwerenda SQL nie jest wykonywana
$items = $customers[0]->orders[0]->items;
```

```php 
// znajdź klientów i pobierz ich kraje zamieszkania i aktywne zamówienia
// SELECT * FROM `customer`
// SELECT * FROM `country` WHERE `id` IN (...)
// SELECT * FROM `order` WHERE `customer_id` IN (...) AND `status` = 1
$customers = Customer::find()->with([
    'country',
    'orders' => function ($query) {
        $query->andWhere(['status' => Order::STATUS_ACTIVE]);
    },
])->all();
```