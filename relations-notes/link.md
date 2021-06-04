### Linkowanie relacji

Klasyka:
```php 
$order = new Order();
$order->subtotal = 100;
// ...

// ustawianie wartości dla atrybutu definiującego relację "customer" dla Order
$customer = Customer::findOne(123);
$order->customer_id = $customer->id;
$order->save();
```

Wykorzystując `link()`

```php 
$order = new Order();
$order->subtotal = 100;
// ...

$order->link('customer', Customer::findOne(123));
```

#### Many to Many

Dodanie rekordu w tabeli węzła za pomocą link:

```php 
$order->link('items', $item);
```

#### Usuwanie relacji

Wykorzystując `unlink()`

```php 
$order->unlink('items', $item, true);
```
 
> Najlepiej od razu z parametrem true, wtedy kasuje rekord z tabeli węzła. Inaczej daje tylko `null`.

 