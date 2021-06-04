### Migracje w plikach php
Przykładowy plik z migracją tworzący nową tabelę
```php 
use yii\db\Migration;

class m150101_185401_create_news_table extends Migration
{
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('news');
        
        # albo zwrócić false informując yii, że danej migracji nie można wycofać
        // return false;
    }
}
```
--- 

Dodawanie zależności między tabelami
```php 
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->defaultValue(1),
            // ...
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-post-author_id',   # nazwa indexu
            'post',                 # nazwa tabeli
            'author_id'             # nazwa kolumny
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-author_id',    # nazwa klucza obcego
            'post',                 # tabela
            'author_id',            # kolumna
            'user',                 # tabela obca
            'id',                   # kolumna w tabeli obcej
            'CASCADE',              # akcja dla delete
                                    # RESTRICT, CASCADE, NO ACTION, SET DEFAULT, SET NULL
            'CASCADE'               # akcja dla update
                                    # RESTRICT, CASCADE, NO ACTION, SET DEFAULT, SET NULL
        );

        // creates index for column `category_id`
        $this->createIndex('idx-post-category_id', 'post', 'category_id');

        // add foreign key for table `category`
        $this->addForeignKey('fk-post-category_id', 'post', 'category_id', 'category', 'id', 'CASCADE');
    } // end up

    /**
     * Ważne aby kolejność w takim przypadku była odwrotna
     * shshhshshshshshshshhshshsh
     * {@inheritdoc}
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey('fk-post-author_id', 'post');

        // drops index for column `author_id`
        $this->dropIndex('idx-post-author_id', 'post');

        // drops foreign key for table `category`
        $this->dropForeignKey('fk-post-category_id', 'post');

        // drops index for column `category_id`
        $this->dropIndex('idx-post-category_id', 'post');

        $this->dropTable('post');
    }
```

---

### Metody pozwalające na dostęp do bazy danych

[Doc](https://www.yiiframework.com/doc/guide/2.0/pl/db-migrations#db-accessing-methods)

| Metoda | Opis|
| --- | --- |
| execute() | wykonywanie komendy SQL |
| insert() | dodawanie pojedynczego wiersza |
| batchInsert() | dodawanie wielu wierszy |
| upsert() | dodawanie pojedynczego wiersza lub aktualizowanie go, jeśli już istnieje (od 2.0.14) |
| update() | aktualizowanie wierszy |
| delete() | usuwanie wierszy |
| createTable() | tworzenie tabeli |
| renameTable() | zmiana nazwy tabeli |
| dropTable() | usuwanie tabeli |
| truncateTable() | usuwanie wszystkich wierszy w tabeli |
| addColumn() | dodawanie kolumny |
| renameColumn() | zmiana nazwy kolumny |
| dropColumn() | usuwanie kolumny |
| alterColumn() | zmiana definicji kolumny |
| addPrimaryKey() | dodawanie klucza głównego |
| dropPrimaryKey() | usuwanie klucza głównego |
| addForeignKey() | dodawanie klucza obcego |
| dropForeignKey() | usuwanie klucza obcego |
| createIndex() | tworzenie indeksu |
| dropIndex() | usuwanie indeksu |
| addCommentOnColumn() | dodawanie komentarza do kolumny |
| dropCommentFromColumn() | usuwanie komentarza z kolumny |
| addCommentOnTable() | dodawanie komentarza do tabeli |
| dropCommentFromTable() | usuwanie komentarza z tabeli |

---

### Metody definiujące kolumny w bazie danych

[Doc](https://www.yiiframework.com/doc/api/2.0/yii-db-schemabuildertrait)

| Method | Description | Defined By |
| --- | --- | --- |
| bigInteger() | Creates a bigint column. | yii\db\SchemaBuilderTrait |
| bigPrimaryKey() | Creates a big primary key column. | yii\db\SchemaBuilderTrait |
| binary() | Creates a binary column. | yii\db\SchemaBuilderTrait |
| boolean() | Creates a boolean column. | yii\db\SchemaBuilderTrait |
| char() | Creates a char column. | yii\db\SchemaBuilderTrait |
| date() | Creates a date column. | yii\db\SchemaBuilderTrait |
| dateTime() | Creates a datetime column. | yii\db\SchemaBuilderTrait |
| decimal() | Creates a decimal column. | yii\db\SchemaBuilderTrait |
| double() | Creates a double column. | yii\db\SchemaBuilderTrait |
| float() | Creates a float column. | yii\db\SchemaBuilderTrait |
| integer() | Creates an integer column. | yii\db\SchemaBuilderTrait |
| json() | Creates a JSON column. | yii\db\SchemaBuilderTrait |
| money() | Creates a money column. | yii\db\SchemaBuilderTrait |
| primaryKey() | Creates a primary key column. | yii\db\SchemaBuilderTrait |
| smallInteger() | Creates a smallint column. | yii\db\SchemaBuilderTrait |
| string() | Creates a string column. | yii\db\SchemaBuilderTrait |
| text() | Creates a text column. | yii\db\SchemaBuilderTrait |
| time() | Creates a time column. | yii\db\SchemaBuilderTrait |
| timestamp() | Creates a timestamp column. | yii\db\SchemaBuilderTrait |
| tinyInteger() | Creates a tinyint column. If tinyint is not supported by the DBMS, smallint will be used. | yii\db\SchemaBuilderTrait |

---




