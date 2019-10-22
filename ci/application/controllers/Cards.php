<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Distributed-learning-api
 * 
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
            if (!($this->input->post('question') and $this->input->post('answer') 
                and $this->input->post('category'))
            ) {
                show_error("Parameters are not enough for the request.");
            } else {
                if ($this->Card_Model->createCard(
                    $this->input->post('question'), 
                    $this->input->post('answer'), 
                    $this->input->post('category')
                )
                ) {
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(
                            json_encode(
                                array(
                                    'message' => 
                                    "Your card has been created successfully."
                                )
                            )
                        );
                } else {
                    show_error("Your card has NOT been created successfully.");
                }
            }
        }
    }

    public function read() 
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404('views/errors/html/error_404.php');
        } else {
            $read_result = $this->Card_Model->readCards();
            if (isset($read_result)) {
                $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode($read_result));
            } else {
                show_error("There are no cards or cards CANNOT be read correctly.");
            }           
        }        
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404('views/errors/html/error_404.php');
        } else {
            if (!($this->input->post('id') and $this->input->post('question')
                and $this->input->post('answer') and $this->input->post('category'))
            ) {
                show_error("Parameters are not enough for the request.");
            } else {
                if (!$this->Card_Model->readCardById($this->input->post('id'))) {
                    show_error("The id does not exist. Please use correct id.");
                }

                if ($this->Card_Model->updateCard(
                    $this->input->post('id'), 
                    $this->input->post('question'), 
                    $this->input->post('answer'), 
                    $this->input->post('category')
                )
                ) {
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(
                            json_encode(
                                array(
                                    'message' => 
                                    "Your card has been updated successfully."
                                )
                            )
                        );
                } else {
                    show_error("Your card has NOT been updated successfully.");
                }
            }
        }
    }

    public function delete() 
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            show_404('views/errors/html/error_404.php');
        } else {
            if (!$this->input->post('id')) {
                show_error("Parameters are not enough for the request.");
            } else {
                if (!$this->Card_Model->readCardById($this->input->post('id'))) {
                    show_error("The id does not exist. Please use correct id.");
                }
                
                if ($this->Card_Model->deleteCard($this->input->post('id'))) {
                    $this->output
                        ->set_content_type('application/json')
                        ->set_output(
                            json_encode(
                                array(
                                    'message' =>
                                    "Your card has been deleted successfully."
                                )
                            )
                        );
                } else {
                    show_error("Your card has NOT been deleted successfully.");
                }
            }
        }
    }
}
