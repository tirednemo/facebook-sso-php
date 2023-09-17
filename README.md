# facebook-sso-php

- Go to [Facebook Developers](https://developers.facebook.com/apps)
  - Create your app
  - Specify the Site URL where Facebook should redirect after a successful login
  - Add [additional permissions](https://developers.facebook.com/apps/120945277695523/permissions?use_case_enum=FB_LOGIN), if required, for retrieving information other than public profile.
  - Note down the App ID and App secret.
- In your project, create a new `composer.json` file or update the existing one if you already have one.
- Install from Packagist
    ```
    composer require red-dot/facebook-sso:dev-main
    ```
- Now, to use the FacebookSSO package in your project 
  - Include the Composer autoloader with `require_once __DIR__ . '/vendor/autoload.php';` at the top of your PHP file.
  - Import the namespace `use RedDot\FacebookSSO\FacebookSSO;`.
  - Create an instance of the FacebookSSO class `$facebookSSO = new FacebookSSO($clientId, $clientSecret, $redirectUri);`.
  - Make sure to replace `$clientId`, `$clientSecret`, and `$redirectUri` with your actual values.
  - That's it! You can now use the FacebookSSO package in your projecs!
- Check out the `examples/example-login.php` file for usage reference. 

Reference: [Manually Build a Login Flow](https://developers.facebook.com/docs/facebook-login/guides/advanced/manual-flow/)
