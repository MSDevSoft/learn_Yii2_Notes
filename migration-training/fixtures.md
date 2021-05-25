### Fixtures and seeds
Dane dla aplikacji możemy wygenerować na kilka sposobów:

1. batchInsert
    - Przygotowanie danych w tablicy i wrzucenie ich do bazy jednym wielkim insertem.
2. Wygenerowanie danych poprzez faker generator:

```php 
// commands/SeedController.php
namespace app\commands;

use yii\console\Controller;
use app\models\Users;
use app\models\Profile;

class SeedController extends Controller
{
    public function actionIndex()
    {
        $faker = \Faker\Factory::create();

        $user = new Users();
        $profile = new Profile();
        for ( $i = 1; $i <= 20; $i++ )
        {
            $user->setIsNewRecord(true);
            $user->user_id = null;

            $user->username = $faker->username;
            $user->password = '123456';
            if ( $user->save() )
            {
                $profile->setIsNewRecord(true);
                $profile->user_id = null;

                $profile->user_id = $user->user_id;
                $profile->email = $faker->email;
                $profile->first_name = $faker->firstName;
                $profile->last_name = $faker->lastName;
                $profile->save();
            }
        }

    }
}
```

3. Skorzystanie z pluginów automatycznych - [Doc](https://www.yiiframework.com/extension/yii2-db-seeder)
4. Fixtures z testów - [Doc](https://www.yiiframework.com/doc/guide/2.0/pl/test-fixtures)