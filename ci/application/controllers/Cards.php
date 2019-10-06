<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Distributed-learning-api
 * @author    Coroccu <https://github.com/coroccu>
 * @copyright 2019 Coroccu
 * @license   MIT License
 * @link      https://github.com/coroccu/distributed-learning-api
 */

class Cards extends CI_Controller
{
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404('views/errors/html/error_404.php');
        } else {
            if (!(isset($_POST['question']) and isset($_POST['answer']) and isset($_POST['category']))) {
                show_error("Parameters are not enough for the request.");
            } else {
                if ($this->Card_Model->createCard(
                    $_POST['question'], 
                    $_POST['answer'], 
                    $_POST['category']
                )
                ) {
                    echo "Your card has been created successfully.";
                } else {
                    // How Can I test this case?
                    show_error("Your card has NOT been created successfully.");
                }
            }
        }
    }
}
