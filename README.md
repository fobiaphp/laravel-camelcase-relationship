laravel-camelcase-relationship
==============================

Позволяет обращаться к отношением модели и загружать их лениво по snake_case синтаксису

В оригинале, к отношениям можно оброщаться так же ка определен метод отношений. Медоты, как правило, именованы стилем camel_case.
Однако при конвертации в масив, все поля преобразуются в snake_case


```PHP
$c = App\Models\Company::first();
$c->legalForm;           // App\Models\LegalForms\LegalForm {#}
$c->legal_form;          // null
$c->load('legal_form');  // Error: RelationNotFoundException
$c->toArray();           //
/*
{
   "id": 1,
   "name": "first name",
   "legal_form": {
     "id": 1,
     "name": "relation name"
   }
}
*/
```


Трейд `CamelCaseRelationship` позволяет обращать к отношениям синтаксисом snake_case


### Usage Instructions


```PHP

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Fobia\Relationship\CamelCaseRelationship;

/**
 * Class Company
 *
 * @property-read \App\LegalForm $legalForm
 * @property-read \App\LegalForm $legal_form
 */
class Company extends Model
{
    use CamelCaseRelationship;

    /**
     * @return BelongsTo
     */
    public function legalForm() : BelongsTo
    {
        return $this->belongsTo(LegalForm::class);
    }
}
```


После вы сможете обращаться к отношению через синтаксис snake_case


```PHP

$company = App\Company::first();
$company->legal_form;         // App\LegalForm {#}
$company->load('legal_form'); // App\Models\Company {#}

$company->loadMissing('legal_form'); // App\Company {#}

// Поддерживается вложенная загрузка отношений
$company->load('legal_form:id'); // convert => legalForm:id
$company->load('legal_form:parent_id'); // convert => legalForm:parent_id
$company->load('legal_form.sub_rel.dubl_ssub_rel'); // convert => legalForm.subRel.dublSsubRel
$company->load('legal_form as foo'); // no convert

```


## License


Laravel Scout is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT)
