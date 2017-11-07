Jincon\AiiValidator
=====

AiiValidator is a simple & easy php  validation package.


### Install

If you have Composer, just include TinyValidator as a project dependency in your `composer.json`. If you don't just install it by downloading the .ZIP file and extracting it to your project directory.

```json
require: {
    "jincon/aiivalidator": "*"
}
```

### Examples

```php
$data = ['title'=>'你', 'email'=>'1@baiducom'];
$rules = [
  'title' => 'required|min:3|max:255',
  'email' => 'required|email',
];

$validator = new \Jincon\AiiValidator\AiiValidator($data, $rules);

//$validator = new \Jincon\AiiValidator\AiiValidator($data, $rules,'en');

if ( !$validator->success ) {
  foreach ($validator->errors as $error) {
    echo $error.'<br>';
  }
}
```

### License

The AiiValidator is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
