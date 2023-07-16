# Extending Formr

This repo contains classes which will extend Formr by creating your own custom [dropdown menus](https://formr.github.io/methods/#input_select), field wrappers, and [FastForm](https://formr.github.io/fastform/) forms.

## Installation

Install [Formr](https://github.com/formr/formr) into your project, then download this repo and put the `my_classes` folder into your `Formr` folder. That's it, you're ready to go!

Note that your custom method names have to be unique, so it's a good idea to either prepend your methods with a unique word, such as `"my"` e.g.; `myDropdownMenu`, or look inside the appropriate class in `Formr/lib/` to make sure it isn't already used by Formr.

## Creating Custom Dropdowns

As you know, a `<select>` menu (dropdown) is nothing more than a series of option tags, consisting of a `value` and a `string` of text contained inside the element.

```html
<label>Say Hi!</label>
<select name="hello">
  <option value="hello_world">Hello, World!</option>
</select>
```

This is really easy to create in Formr, as the select menus are nothing more than simple arrays. Just give your custom method a name, then assign the select menu's `option value` to the `array key`, and the `option string` to the `array value`.

```php
class MyDropdowns extends Dropdowns
{
  public static function my_hello()
  {
    return [
      'hello_world' => 'Hello, World!',
    ];
  }
}
```

And then use it like so

```php
$form->select('hello', 'Say Hi!', '', '', '', '', '', 'my_hello');
```

---

## Creating Custom Forms

You can create your own forms to be used with [FastForm](https://formr.github.io/fastform/) by creating simple arrays and strings. While it may look complicated, it's actually very easy!

1. The array `key` is the form element type you want to use, e.g.; `text`, `password`, `textarea`, etc.
2. The array `value` contains the element's parameters.

###### This is how you would normally add an `<input type="text">` element in Formr

```php
$form->text('name', 'Your name', '', 'nameID', 'placeholder="Your name"');
```

###### This is how you would build the same `<input type="text">` element for FastForm. As you can see, they're basically the same thing!

```php
'text' => 'name,Your name,,nameID,placeholder="Your name"'
```

## Validating Your Custom Forms

Validating your custom forms is just as easy!

1. The array `key` is the form field's `name`.
2. The array `value` is an array which contains an error message string, and the validation methods.

```php
'username' => ['Username|Please enter your username', 'required|min[3]'],
```

#### Example Login Form

This is the example login form that comes with the `MyForms` class. Notice how you build your form - and validate it - with simple arrays?

```php
class MyForms extends Forms
{
  public static function my_login($validate = '')
  {
    if (!$validate) {
      // build the form
      return [
        'text' => 'username,Username,,usernameID',
        'password' => 'password,Password,,passwordID',
        'submit' => 'submit,,Login',
      ];
    } else {
      // validate the form
      return [
        'username' => [
          'Username|Please enter your username',
          'required|min[3]',
        ],
        'password' => ['Password|Please enter your password', 'required|hash'],
      ];
    }
  }
}
```

Here's an example of how to use it in your page.

```php
<!DOCTYPE html>
<head>
    <title>Login</title>
</head>
<body>
<?php
$form = new Formr();

if ($form->submitted()) {
  // validate the $_POST data
  $post = $form->fastpost('my_login');

  $username = $post['username'];
  $password = $post['password'];
}

// print the form
$form->fastform('my_login');
?>
</body>
</html>

```

## Creating Custom Wrappers

Creating custom wrappers in Formr is a bit more complicated and should only be done by someone who is comfortable with HTML and PHP. The basic premise is that there are two methods which work together: the `CSS` method and the `Wrapper` method. The Wrapper method will use CSS classes from the CSS method, so they must go together.

The best way to get started with Wrappers is to install this package and then take a look at the `simple_wrapper()` method and play around with it.

```php
class MyWrappers extends Wrapper
{
  public function simple_wrapper($element = '', $data = '')
  {
    if (empty($data)) {
      return false;
    }

    # open the enclosing <div>
    $return = '<div id="' . $this->formr->make_id($data) . '" class="my-div">';

    # let's create a <label> (if label text was supplied)
    if ($this->formr->is_not_empty($data['label'])) {
      # open the <label>
      $return .=
        '<label class="my-label" for="' . $this->formr->make_id($data) . '">';

      # insert the <label> text
      $return .= $data['label'];

      # add a required field indicator (*) if present
      $return .= $this->formr->insert_required_indicator($data);

      # close the <label>
      $return .= '</label>';
    }

    # add the field element, e.g.; <input type="text">
    $return .= $element;

    # close the <div>
    $return .= '</div>';

    return $return;
  }
}
```

#### Let's try the simple_wrapper()

```php
$form = new Formr('simple_wrapper');
$form->text('name', 'Name');

// outputs the following HTML
<div id="name" class="my-div">
    <label class="my-label" for="name">Name</label>
    <input type="text" name="name" id="name" class="form-control">
</div>
```
