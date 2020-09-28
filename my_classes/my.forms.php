<?php

class MyForms
{
    # FastForm instructions available at: https://formr.github.io/fastform/
    
    # here's a sample FastForm login form to get you started
    public static function my_login($validate = '')
    {
        if (!$validate) {

            // let's build the form
            // we'll add a text field, a password field, and a submit button

            // array key = type of form field
            // array value = field name, field label, default value, field ID, Bootstrap help text, custom string

            return [
                'text' => 'username,Username,,usernameID,,placeholder="Enter your username"',
                'password' => 'password,Password,,passwordID,,placeholder="Enter your password"',
                'submit' => 'submit,,Login'
            ];
        } else {

            // let's validate our form

            // array key = field name
            // array value = ['Human readable error message text', 'Validation Methods']

            return [
                'username' => ['Username|Please enter your username', 'required|min[3]'],
                'password' => ['Password|Please enter your password', 'required|hash']
            ];
        }
    }
}
