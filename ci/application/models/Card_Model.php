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

class Card_Model extends CI_Model
{
    public function createCard($question, $answer, $category) 
    {
        $data = array(
            'question' => $question,
            'answer' => $answer,
            'category' => $category
        );

        $insert_result = $this->db->insert('cards', $data);
        return $insert_result;
    }

    public function readCards()
    {
        $get_result = $this->db->get('cards');
        return $get_result->result();
    }
}
?>