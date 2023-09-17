<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use RedDot\FacebookSSO\FacebookSSO;

$clientId = 'YOUR APP ID';
$clientSecret = 'YOUR APP SECRET';
$redirectUri = 'http://localhost/facebook-sso-php/examples/example-login.php';

$facebookSSO = new FacebookSSO($clientId, $clientSecret, $redirectUri);

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $userData = $facebookSSO->handleCallback($code);
    $fbId = $userData['id'];
    $fbName = $userData['name'];
    $fbEmail = $userData['email'];
    $fbPic = $userData['picture'];
}

$loginUrl = $facebookSSO->getLoginUrl();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Home Page - Robishop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
        }

        .navbar {
            background-color: #e13133;
            color: #ffffff;
            padding: 10px;
            position: relative;
        }

        .shop-name {
            color: #ffffff;
            font-size: 24px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .login-button {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            background-color: #ffffff;
            text-align: center;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #ffffff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 400px;
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group button {
            background-color: #e13133;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .fbbutton {
            background-color: #e13133;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <div class="login-button" id="loginButton">
            <?php if (isset($fbPic)): ?>
                <img src="<?php echo $fbPic; ?>" style='height:40px; width: 40px;' alt="Profile Picture">
            <?php else: ?>
                <i class="fas fa-user-circle fa-lg" style="color: red;"></i>
            <?php endif; ?>
        </div>
        <span class="shop-name">Robishop</span>
    </div>

    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <?php if (isset($fbId)): ?>
                <div>
                    <p>
                        <label>ID:</label>
                        <?php echo $fbId; ?>
                    </p>
                </div>
                <div>
                    <p>
                        <label>Name:</label>
                        <?php echo $fbName; ?>
                    </p>
                </div>
                <?php if (isset($fbEmail)): ?>
                <div>
                    <p>
                        <label>Email:</label>
                        <?php echo $fbEmail; ?>
                    </p>
                </div>
                <?php endif; ?>
                <div>
                    <p>
                        <label>Picture:</label>
                        <img src='<?php echo $fbPic; ?>' style='height:70px; width: 70px;' />

                    </p>
                </div>
            <?php else: ?>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="text" placeholder="Enter your email">
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" placeholder="Enter your password">
                </div>
                <div class="form-group">
                    <button>Login</button>
                </div>
                <div>
                    <button class="fbbutton" onclick="loginWithFacebook()" style="background-color: #3b5998;">
                        <i class="fab fa-facebook-square" style="color: white;"></i> Login with Facebook</button>
                </div>

            <?php endif; ?>
        </div>
    </div>

    <script>
        var loginButton = document.getElementById('loginButton');
        var loginModal = document.getElementById('loginModal');

        function openModal() {
            loginModal.style.display = 'block';
        }

        function closeModal() {
            loginModal.style.display = 'none';
        }

        function loginWithFacebook() {
            window.location.href = '<?php echo $loginUrl; ?>';
        }

        loginButton.addEventListener('click', function () {
            openModal();
        });
    </script>
</body>

</html>