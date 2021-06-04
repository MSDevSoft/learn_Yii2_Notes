### Własne klasy ActiveQuery

W dużych projektach przy sporej ilości zapytań w modelu lepiej jest stworzyć dodatkową klasę ActiveQuery, która będzie przechowywała dodatkowe zapytania bazodanowe.
[doc](https://www.yiiframework.com/doc/guide/2.0/pl/db-active-record#customizing-query-classes)

Przykładowa klasa:

```php 
// plik CommentQuery.php
namespace app\models;

use yii\db\ActiveQuery;

class CommentQuery extends ActiveQuery
{
    // ... dodaj zmodyfikowane metody kwerend w tym miejscu ...

    public function active($state = true)
    {
        return $this->andOnCondition(['active' => $state]);
    }
}
```

Złączenie ActiveRecord z ActiveQuery działa na zasadzie nadpisania statycznej metody find w modelu.

```php 
// plik Comment.php
namespace app\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    /// ...

    public static function find()
    {
        return new CommentQuery(get_called_class());
    }
}
```

Wywołanie:

```php 
$comments = Comment::find()->active()->all();
$inactiveComments = Comment::find()->active(false)->all();
```

