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

class Cards_Test extends TestCase
{
    public function testApiCreateSuccess() 
    {
        $this->request->setCallable(
            function ($CI) {
                $card_model = $this->getDouble(
                    'Card_Model', 
                    ['createCard' => true]
                );
                $CI->Card_Model = $card_model;
            }
        );
        $output = $this->request(
            'POST', ['Cards', 'create'], [
            'question' => 'QuestionControllerCreateTest',
            'answer' => 'AnswerControllerCreateTest',
            'category' => 'CategoryControllerCreateTest'
            ]
        );

        $this->assertResponseCode(200);
        $this->assertContains("Your card has been created successfully.", $output);
    }

    public function testApiCreateError() 
    {
        $this->request->setCallable(
            function ($CI) {
                $card_model = $this->getDouble(
                    'Card_Model', 
                    ['createCard' => false]
                );
                $CI->Card_Model = $card_model;
            }
        );
        $output = $this->request(
            'POST', ['Cards', 'create'], [
            'question' => 'QuestionControllerCreateTest',
            'answer' => 'AnswerControllerCreateTest',
            'category' => 'CategoryControllerCreateTest'
            ]
        );

        $this->assertResponseCode(500);
        $this->assertContains("Your card has NOT been created successfully.", $output);
    }

    public function testApiCreateErrorNoParameters() {
        $output = $this->request('POST', ['Cards', 'create']);
        $this->assertResponseCode(500);
    }

    public function testApiCreateErrorQuestionParameter() {
        $output = $this->request(
            'POST', ['Cards', 'create'], 
            ['question' => 'QuestionControllerCreateTest']
        );
        $this->assertResponseCode(500);
    }

    public function testApiCreatePOSTErrorAnswerParameter() {
        $output = $this->request(
            'POST', 
            ['Cards', 'create'], 
            ['answer' => 'AnswerControllerCreateTest']
        );
        $this->assertResponseCode(500);
    }

    public function testApiCreatePOSTErrorCategoryParameter() {
        $output = $this->request(
            'POST', ['Cards', 'create'], 
            ['category' => 'CategoryControllerCreateTest']
        );
        $this->assertResponseCode(500);
    }

    public function testApiCreateGETError() {
        $this->request('GET', ['Cards', 'create']);
        $this->assertResponseCode(404);
    }

    public function testApiReadSuccess() 
    {
        $this->request->setCallable(
            function ($CI) {
                $card_model = $this->getDouble(
                    'Card_Model', 
                    ['readCards' => [
                        'question' => 'QuestionControllerReadTest',
                        'answer' => 'AnswerControllerReadTest',
                        'category' => 'CategoryControllerReadTest'
                        ]
                    ]
                );
                $CI->Card_Model = $card_model;
            }
        );

        $output = $this->request('POST', ['Cards', 'read']);
        $this->assertResponseCode(200);
        $this->assertContains('QuestionControllerReadTest', $output);
    }    

    public function testApiReadError() 
    {
        $this->request->setCallable(
            function ($CI) {
                $card_model = $this->getDouble(
                    'Card_Model', 
                    ['readCards' => null]
                );
                $CI->Card_Model = $card_model;
            }
        );

        $output = $this->request('POST', ['Cards', 'read']);
        $this->assertResponseCode(500);
        $this->assertContains('There are no cards or cards CANNOT be read correctly.', $output);
    }  

    public function testApiReadGETError() 
    {
        $this->request('GET', ['Cards', 'read']);
        $this->assertResponseCode(404);
    }
}   