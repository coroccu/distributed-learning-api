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

class Card_Model_Test extends TestCase
{
    public function setUp()
    {
        $this->resetInstance();
        $this->CI->load->model('Card_Model');
        $this->obj = $this->CI->Card_Model;
        $this->test_data = array(
            'create' => array(
                'question' => 'QuestionModelCreateTest',
                'answer' => 'AnswerModelCreateTest',
                'category' => 'CategoryModelCreateTest'
            ),
            'read' => array(
                'question' => 'QuestionModelReadTest',
                'answer' => 'AnswerModelReadTest',
                'category' => 'CategoryModelReadTest'
            ),
            'update' => array(
                'before' => array(
                    'question' => 'QuestionModelUpdateTest',
                    'answer' => 'AnswerModelUpdateTest',
                    'category' => 'CategoryModelUpdateTest'
                ),
                'after' => array(
                    'question' => 'QuestionModelUPDATEDTest',
                    'answer' => 'AnswerModelUPDATEDTest',
                    'category' => 'CategoryModelUPDATEDTest'
                )
                ),
        );

        $this->obj->db->insert('cards', $this->test_data['read']);
        $this->obj->db->insert('cards', $this->test_data['update']['before']);
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
        $this->assertEquals(1, $select_result->num_rows());
    }

    public function testReadCards()
    {
        $read_result = $this->obj->readCards();
        foreach ($read_result as $key => $value) {
            if ($value->question == $this->test_data['read']['question']) {
                $this->assertContains(
                    $this->test_data['read']['answer'], 
                    $value->answer
                );

                $this->assertContains(
                    $this->test_data['read']['category'], 
                    $value->category
                );
            }
        }
    }

    public function testReadCardById()
    {
        $this->obj->db->where(
            'question', 
            $this->test_data['read']['question']
        );

        $select_result = $this->obj->db->get('cards')->result();
        $id = $select_result[0]->id;

        $read_result = $this->obj->readCardById($id);

        $this->assertContains(
            $this->test_data['read']['answer'], 
            $read_result[0]->answer
        );

        $this->assertContains(
            $this->test_data['read']['category'], 
            $read_result[0]->category
        );
    }

    public function testUpdateCard()
    {
        $this->obj->db->where(
            'question', 
            $this->test_data['update']['before']['question']
        );

        $select_result = $this->obj->db->get('cards')->result();
        $id = $select_result[0]->id;

        $update_result = $this->obj->updateCard(
            $id,
            $this->test_data['update']['after']['question'],
            $this->test_data['update']['after']['answer'],
            $this->test_data['update']['after']['category']
        );

        $this->assertEquals(true, $update_result);

        $this->obj->db->where('id', $id);
        $updated_item = $this->obj->db->get('cards')->result();
        $this->assertEquals(
            $this->test_data['update']['after']['question'], 
            $updated_item[0]->question
        );
    }

    public function testDeleteCard() 
    {
        $test_data = array(
            'question' => 'QuestionModelDeleteTest',
            'answer' => 'AnswerModelDeleteTest',
            'category' => 'CategoryModelDeleteTest'
        );

        $this->obj->db->insert('cards', $test_data);

        $this->obj->db->where(
            'question', 
            $test_data['question']
        );

        $select_result = $this->obj->db->get('cards')->result();
        $id = $select_result[0]->id;
        $delete_result = $this->obj->deleteCard($id);
        $this->assertEquals(true, $delete_result);

        $this->obj->db->where('id', $id);
        $deleted_item = $this->obj->db->get('cards')->result();
        $this->assertEquals(0, count($deleted_item));
    } 

    public function tearDown()
    {
        $this->obj->db->where('question', $this->test_data['create']['question']);
        $this->obj->db->or_where('question', $this->test_data['read']['question']);
        $this->obj->db->or_where(
            'question', 
            $this->test_data['update']['before']['question']
        );
        $this->obj->db->or_where(
            'question', 
            $this->test_data['update']['after']['question']
        );
        $this->obj->db->delete('cards');
    }
}

?>