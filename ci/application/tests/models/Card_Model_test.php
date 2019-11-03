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
    }

    public function test_CreateCard_Success()
    {
        $test_data = array(
            'question' => 'QuestionModelCreateTest',
            'answer' => 'AnswerModelCreateTest',
            'category' => 'CategoryModelCreateTest'
        );

        $create_result = $this->obj->createCard(
            $test_data['question'], 
            $test_data['answer'], 
            $test_data['category']
        );

        $this->assertEquals(true, $create_result);
        $this->obj->db->where('question', $test_data['question']);

        $select_result = $this->obj->db->get('cards');
        $this->assertEquals(1, $select_result->num_rows());

        $this->obj->db->where('question', $test_data['question']);
        $this->obj->db->delete('cards');
    }

    public function test_ReadCards_Success()
    {
        $test_data = array(
            'question' => 'QuestionModelReadTest',
            'answer' => 'AnswerModelReadTest',
            'category' => 'CategoryModelReadTest'
        );

        $this->obj->db->insert('cards', $test_data);

        $read_result = $this->obj->readCards();
        foreach ($read_result as $key => $value) {
            if ($value->question == $test_data['question']) {
                $this->assertContains(
                    $test_data['answer'], 
                    $value->answer
                );

                $this->assertContains(
                    $test_data['category'], 
                    $value->category
                );
            }
        }

        $this->obj->db->where('question', $test_data['question']);
        $this->obj->db->delete('cards');
    }

    public function test_ReadCardById_Success()
    {
        $test_data = array(
            'question' => 'QuestionModelReadTest',
            'answer' => 'AnswerModelReadTest',
            'category' => 'CategoryModelReadTest'
        );

        $this->obj->db->insert('cards', $test_data);

        $this->obj->db->where(
            'question', 
            $test_data['question']
        );

        $select_result = $this->obj->db->get('cards')->result();
        $id = $select_result[0]->id;

        $read_result = $this->obj->readCardById($id);

        $this->assertContains(
            $test_data['answer'], 
            $read_result[0]->answer
        );

        $this->assertContains(
            $test_data['category'], 
            $read_result[0]->category
        );

        $this->obj->db->where('question', $test_data['question']);
        $this->obj->db->delete('cards');
    }

    public function test_UpdateCard_Success()
    {
        $test_data = array(
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
        );

        $this->obj->db->insert('cards', $test_data['before']);

        $this->obj->db->where(
            'question', 
            $test_data['before']['question']
        );

        $select_result = $this->obj->db->get('cards')->result();
        $id = $select_result[0]->id;

        $update_result = $this->obj->updateCard(
            $id,
            $test_data['after']['question'],
            $test_data['after']['answer'],
            $test_data['after']['category']
        );

        $this->assertEquals(true, $update_result);

        $this->obj->db->where('id', $id);
        $updated_item = $this->obj->db->get('cards')->result();
        $this->assertEquals(
            $test_data['after']['question'], 
            $updated_item[0]->question
        );

        $this->obj->db->where(
            'question', 
            $test_data['before']['question']
        );
        $this->obj->db->or_where(
            'question', 
            $test_data['after']['question']
        );
        $this->obj->db->delete('cards');
    }

    public function test_DeleteCard_Success() 
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
}

?>