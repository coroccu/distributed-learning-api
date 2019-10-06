<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Distributed-learning-api
 * @author    Coroccu <https://github.com/coroccu>
 * @copyright 2019 Coroccu
 * @license   MIT License
 * @link      https://github.com/coroccu/distributed-learning-api
 */

class Card_Model_Test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Card_Model');
        $this->obj = $this->CI->Card_Model;
        $this->test_data = array(
            'create' => array(
                'question' => 'Question1',
                'answer' => 'Answer1',
                'category' => 'Category1'
            )
        );
    }

    public function testCreateCard()
    {
        $create_result = $this->obj->createCard(
            $this->test_data['create']['question'], 
            $this->test_data['create']['answer'], 
            $this->test_data['create']['category']
        );

        $this->assertEquals(true, $create_result);
        $this->obj->db->where('question', $this->test_data['create']['question']);

        $select_result = $this->obj->db->get('cards');
        $this->assertEquals(2, $select_result->num_rows());
    }

    public function tearDown()
    {
        $this->obj->db->where('question', $this->test_data['create']['question']);
        $this->obj->db->delete('cards');
    }
}

?>