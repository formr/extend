<?php

#[AllowDynamicProperties]
class MyDropdowns extends Dropdowns
{
    # here's a sample dropdown to get you started
    public static function my_hello()
    {
        return [
            'hello_world' => 'Hello, World!',
            'hello_formr' => 'Hello, Formr!',
        ];
    }
}
