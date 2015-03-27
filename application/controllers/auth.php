<?php

/**
 * Class AuthController
 *
 * This class controls logging in and logging out of users.
 */
class AuthController extends Controller
{
    /**
     * PAGE: login
     *
     * If this is a GET request, display the page.
     *
     * If this is a POST request, log the user in if credentials are right.
     */
    public function login()
    {
        // If this is post data:
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            $user = $this->user->verifyUserCredentials($_POST['username'], $_POST['password']);
            
            // Valid user credentials.
            if ($user) {
                $_SESSION['user'] = $user;

                // Ensure session is written before redirecting to index.
                session_write_close();
                header('location: ' . URL_WITH_INDEX_FILE . '');
            }
            // Invalid user credentials.
            else {
                $message = "Your username and/or password is incorrect.";
                require APP . 'views/_templates/header.php';
                require APP . 'views/error/message.php';
                require APP . 'views/auth/login.php';
                require APP . 'views/_templates/footer.php';
            }
        }

        // If this is get data:
        else {
            require APP . 'views/_templates/header.php';
            require APP . 'views/auth/login.php';
            require APP . 'views/_templates/footer.php';
        }
    }

    public function logout() {
        session_unset();
        header('location: ' . URL_WITH_INDEX_FILE . '');
    }

    /**
     * Overloaded loadModel() method. This method is called on __construct().
     */
    public function loadModel()
    {
        require APP . '/models/user.php';
        // create new "model" (and pass the database connection)
        $this->user = new User($this->db);
    }
}
