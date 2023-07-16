<?php

#[AllowDynamicProperties]
class MyForms extends Forms
{
    # this class will let you create and save your own FastForm forms
    # instructions available at: https://formr.github.io/fastform/

    # here's a sample FastForm login form to get you started
    public static function my_login($validate = '')
    {
        if (!$validate) {

            // we'll build the form in this block
            // let's add a text field, a password field, and a submit button

            // array key = type of form field
            // array value = field name, field label, default value, field ID, custom string

            return [
                'text' => 'username,Username,,usernameID,placeholder="Enter your username"',
                'password' => 'password,Password,,passwordID,placeholder="Enter your password"',
                'submit' => 'submit,,Login'
            ];
        } else {

            // we'll validate our form in this block

            // array key = field name
            // array value = ['Human readable error message text', 'Validation Methods']

            return [
                'username' => ['Username|Please enter your username', 'required|min[3]'],
                'password' => ['Password|Please enter your password', 'required|hash']
            ];
        }
    }
}
