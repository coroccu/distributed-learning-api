<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Distributed-learning-api
 * @author    Coroccu <https://github.com/coroccu>
 * @copyright 2019 Coroccu
 * @license   MIT License
 * @link      https://github.com/coroccu/distributed-learning-api
 */

class Cards_Test extends TestCase
{
    public function testApiCreatePOST() {
        $output = $this->request('POST',['Cards', 'create'],[
            'question' => 'Question1',
            'answer' => 'Answer1',
            'category' => 'Category1'
        ]);
        $this->assertResponseCode(200);
        $this->assertEquals("Your card has been created successfully.", $output);
    }

    public function testApiCreatePOSTErrorNoParameters() {
        $output = $this->request('POST',['Cards', 'create']);
        $this->assertResponseCode(500);
    }

    public function testApiCreatePOSTErrorQuestionParameter() {
        $output = $this->request('POST',['Cards', 'create'],[
            'question' => 'Question 1'
        ]);
        $this->assertResponseCode(500);
    }

    public function testApiCreatePOSTErrorAnswerParameter() {
        $output = $this->request('POST',['Cards', 'create'],[
            'answer' => 'Answer 1'
        ]);
        $this->assertResponseCode(500);
    }

    public function testApiCreatePOSTErrorCategoryParameter() {
        $output = $this->request('POST',['Cards', 'create'],[
            'category' => 'Category 1'
        ]);
        $this->assertResponseCode(500);
    }

    public function testApiCreateGET() {
        $output = $this->request('GET',['Cards', 'create']);
        $this->assertResponseCode(404);
    }
}   