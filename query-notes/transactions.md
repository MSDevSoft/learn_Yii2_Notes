### Transakcje w Yii 2.0

Klasyka:   
```php 
$db = Yii::$app->db;
$transaction = $db->beginTransaction();
try {
    $db->createCommand($sql1)->execute();
    $db->createCommand($sql2)->execute();
    // ... executing other SQL statements ...
    
    $transaction->commit();
} catch(\Exception $e | \Throwable $e) {
    $transaction->rollBack();
    throw $e;
}
```

--- 

Wersja skrócona 

```php 
$customer = Customer::findOne(123);
try {
    Customer::getDb()->transaction(function($db) use ($customer) {
        $customer->id = 200;
        $customer->save();
        // ...inne operacje bazodanowe...
    });
} catch(\Exception $e | \Throwable $e) {
    throw $e;
}
```