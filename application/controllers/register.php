<?php

/**
 * Class Register
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class RegisterController extends Controller
{
    /**
     * PAGE: index
     * The main page for registration.
     */
    public function index()
    {
        // if we have POST data
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == 'POST') {
            echo var_dump($this->user);
        }

        // load views
        require APP . 'views/_templates/header.php';
        require APP . 'views/register/index.php';
        require APP . 'views/_templates/footer.php';
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
