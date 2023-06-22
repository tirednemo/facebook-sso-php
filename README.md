# facebook-sso-php

- Register your app in [Facebook Developers](https://developers.facebook.com/apps) and note down the App ID, App secret, and the Site URL where Facebook should redirect after a successful login.
- Create a new `composer.json` file or update the existing one if you already have one.
- To install from Packagist:
  - Add the dependency to FacebookSSO package in the "require" section of the `composer.json` file of your project:
    ```json
    {
      "require": {
        "red-dot/facebook-sso": "1.0.0"
      }
    }
    ```
- To install from GitHub:
  - Clone this repository.
  - Add the path to the local repository path in the "repositories" section and the dependency to FacebookSSO package in the "require" section of the `composer.json` file of your project:
    ```json
    {
      "repositories": [
        {
          "type": "path",
          "url": "/path/to/facebook-sso"
        }
      ],
      "require": {
        "red-dot/facebook-sso": "dev-master"
      }
    }
    ```
- Run `composer install` in the root directory of your project to install the FacebookSSO package and its dependencies.
- Now, to use the FacebookSSO package in your project 
  - Include the Composer autoloader with `require_once 'vendor/autoload.php';` 
  - Add `use RedDot\FacebookSSO\FacebookSSO;` to create an instance of the class. 
  - Check out the `examples/example-login.php` file for usage reference. Make sure to replace `$clientId`, `$clientSecret`, and `$redirectUri` with your actual values.
- That's it! You can now use the FacebookSSO package in your projecs!
