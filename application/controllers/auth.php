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
            if ($user) {
                $_SESSION['user'] = $user;

                // Ensure session is written before redirecting to index.
                session_write_close();
                header('location: ' . URL_WITH_INDEX_FILE . '');
            }
        }

        // If this is get data:
        require APP . 'views/_templates/header.php';
        require APP . 'views/auth/login.php';
        require APP . 'views/_templates/footer.php';
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
