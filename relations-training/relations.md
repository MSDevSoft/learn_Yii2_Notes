### Relacje

Relacje są definiowane w pliku modelu jako metody, które łączą obiekty.

#### One To One
```php 

/**
 * @property int $id
 * @property string $name
 * @property Profile $profile
 */
class User extends ActiveRecord
{
    public function getProfile()
    {
        return $this->hasOne(Profile::class, ['user_id' => 'id'])
            ->inverseOf('user');
    }
}

/**
 * @property int $id
 * @property int $user_id !unicode!
 * @property User $user
 * @property string $data
 */
class Profile extends ActiveRecord
{
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])
            ->inverseOf('profile');
    }
}
```

#### One To Many
```php 
/**
 * @property int $id
 * @property string $name
 *
 * @property Order[] $orders
 */
class Customer extends ActiveRecord
{
    public function getOrders()
    {
        //                                      tam weź    =>  stąd biorąc
        return $this->hasMany(Order::class, ['customer_id' => 'id'])
            ->inverseOf('customer'); // wskazuję relazję odwrotną
    }
}

/**
 * @property int $id
 * @property int $customer_id
 * @property Customer $customer
 */
class Order extends ActiveRecord
{
    public function getCustomer()
    {                                       tam weź =>  stąd biorąc
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }
}
```

> Uwaga na odwołania:
> - $customer->orders; // tablica obiektów `Order`
> - $customer->getOrders(); // instancja `ActiveQuery`

#### Many to Many

```php 
class Order extends ActiveRecord
{
    # tabela węzła -> OrderItem[]
    public function getOrderItems()
    {                                               tam         stąd
        return $this->hasMany(OrderItem::class, ['order_id' => 'id']);
    }

    # tabela końcowa -> Item[]
    public function getItems()
    {                                       tam  =>  biorąc z relacji
        return $this->hasMany(Item::class, ['id' => 'item_id'])
            ->via('orderItems');
    }
    
    # tabela końcowa -> Item[]
    public function getItems()
    {                                       tam  => biorąc z relacji
        return $this->hasMany(Item::class, ['id' => 'item_id'])
            ->viaTable('order_item', ['order_id' => 'id']);
    }                                     tam    =>  stąd
}
```
