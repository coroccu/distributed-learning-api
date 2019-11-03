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
    public function test_CreateAPI_WhenInputQuestionAnswerCategory_200Success() 
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

    public function test_CreateAPI_WhenCardModelCreateCardFail_500Error() 
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

    public function test_CreateAPI_WhenInputNoParameters_500Error() 
    {
        $this->request('POST', ['Cards', 'create']);
        $this->assertResponseCode(500);
    }

    public function test_CreateAPI_WhenInputOnlyQuestion_500Error() 
    {
        $this->request(
            'POST', ['Cards', 'create'], 
            ['question' => 'QuestionControllerCreateTest']
        );
        $this->assertResponseCode(500);
    }

    public function test_CreateAPI_WhenInputOnlyAnswer_500Error() 
    {
        $this->request(
            'POST', 
            ['Cards', 'create'], 
            ['answer' => 'AnswerControllerCreateTest']
        );
        $this->assertResponseCode(500);
    }

    public function test_CreateAPI_WhenInputOnlyCategory_500Error() 
    {
        $this->request(
            'POST', ['Cards', 'create'], 
            ['category' => 'CategoryControllerCreateTest']
        );
        $this->assertResponseCode(500);
    }

    public function test_CreateAPI_WhenAccessWithGetMethod_404Error() 
    {
        $this->request('GET', ['Cards', 'create']);
        $this->assertResponseCode(404);
    }

    public function test_ReadAPI_200Success() 
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

    public function test_ReadAPI_WhenCardModelReadCardsFail_500Error() 
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

    public function test_ReadAPI_WhenAccessWithGetMethod_404Error() 
    {
        $this->request('GET', ['Cards', 'read']);
        $this->assertResponseCode(404);
    }

    public function test_UpdateAPI_WhenInputIdQuestionAnswerCategory_200Success() 
    {
        $this->request->setCallable(
            function ($CI) {
                $card_model = $this->getDouble(
                    'Card_Model', 
                    ['updateCard' => true,'readCardById' => true]
                );
                $CI->Card_Model = $card_model;
            }
        );

        $output = $this->request(
            'POST', ['Cards', 'update'], [
            'id' => '1',
            'question' => 'QuestionControllerUpdateTest',
            'answer' => 'AnswerControllerUpdateTest',
            'category' => 'CategoryControllerUpdateTest'
            ]
        );

        $this->assertResponseCode(200);
        $this->assertContains("Your card has been updated successfully.", $output);
    }

    public function test_UpdateAPI_WhenCardModelUpdateCardFail_500Error() 
    {
        $this->request->setCallable(
            function ($CI) {
                $card_model = $this->getDouble(
                    'Card_Model', 
                    ['updateCard' => false,'readCardById' => true]
                );
                $CI->Card_Model = $card_model;
            }
        );

        $output = $this->request(
            'POST', ['Cards', 'update'], [
            'id' => '1',
            'question' => 'QuestionControllerUpdateTest',
            'answer' => 'AnswerControllerUpdateTest',
            'category' => 'CategoryControllerUpdateTest'
            ]
        );

        $this->assertResponseCode(500);
        $this->assertContains(
            "Your card has NOT been updated successfully.", 
            $output
        );
    }

    public function test_UpdateAPI_WhenInputNoParameters_500Error() 
    {
        $this->request('POST', ['Cards', 'update']);
        $this->assertResponseCode(500);
    }

    public function test_UpdateAPI_WhenInputOnlyId_500Error() 
    {
        $this->request(
            'POST', 
            ['Cards', 'update'], 
            [
                'question' => 'QuestionControllerUpdateTest',
                'answer' => 'AnswerControllerUpdateTest',
                'category' => 'CategoryControllerUpdateTest'
            ]
        );
        $this->assertResponseCode(500);
    }

    public function test_UpdateAPI_WhenInputEmptyId_500Error() 
    {
        $this->request(
            'POST', 
            ['Cards', 'update'], 
            [
                'id' => '',
                'question' => 'QuestionControllerUpdateTest',
                'answer' => 'AnswerControllerUpdateTest',
                'category' => 'CategoryControllerUpdateTest'
            ]
        );
        $this->assertResponseCode(500);
    }

    public function test_UpdateAPI_WhenInputWRONGId_500Error() 
    {
        $this->request->setCallable(
            function ($CI) {
                $card_model = $this->getDouble(
                    'Card_Model', 
                    ['readCardById' => false]
                );
                $CI->Card_Model = $card_model;
            }
        );

        $output = $this->request(
            'POST', ['Cards', 'update'], [
            'id' => 'WRONGID',
            'question' => 'QuestionControllerUpdateTest',
            'answer' => 'AnswerControllerUpdateTest',
            'category' => 'CategoryControllerUpdateTest'
            ]
        );

        $this->assertResponseCode(500);
        $this->assertContains(
            "The id does not exist. Please use correct id.", 
            $output
        );
    }

    public function test_UpdateAPI_WhenNotInputQuestion_500Error() 
    {
        $this->request(
            'POST', 
            ['Cards', 'update'], 
            [
                'id' => '1',
                'answer' => 'AnswerControllerUpdateTest',
                'category' => 'CategoryControllerUpdateTest'
            ]
        );
        $this->assertResponseCode(500);
    }

    public function test_UpdateAPI_WhenNotInputAnswer_500Error() 
    {
        $this->request(
            'POST', 
            ['Cards', 'update'], 
            [
                'id' => '1',
                'question' => 'QuestionControllerUpdateTest',
                'category' => 'CategoryControllerUpdateTest'
            ]
        );
        $this->assertResponseCode(500);
    }

    public function test_UpdateAPI_WhenNotInputCategory_500Error() 
    {
        $this->request(
            'POST', 
            ['Cards', 'update'], 
            [
                'id' => '1',
                'question' => 'QuestionControllerUpdateTest',
                'answer' => 'AnswerControllerUpdateTest'
            ]
        );
        $this->assertResponseCode(500);
    }

    public function test_UpdateAPI_WhenAccessWithGetMethod_404Error() 
    {
        $this->request('GET', ['Cards', 'update']);
        $this->assertResponseCode(404);
    }

    public function test_DeleteAPI_WhenInputId_200Success()
    {
        $this->request->setCallable(
            function ($CI) {
                $card_model = $this->getDouble(
                    'Card_Model', 
                    ['deleteCard' => true,'readCardById' => true]
                );
                $CI->Card_Model = $card_model;
            }
        );

        $output = $this->request(
            'POST', ['Cards', 'delete'], [
            'id' => '1'
            ]
        );

        $this->assertResponseCode(200);
        $this->assertContains(
            "Your card has been deleted successfully.", 
            $output
        );        
    }

    public function test_DeleteAPI_WhenCardModelDeleteCardFail_500Error() 
    {
        $this->request->setCallable(
            function ($CI) {
                $card_model = $this->getDouble(
                    'Card_Model', 
                    ['deleteCard' => false,'readCardById' => true]
                );
                $CI->Card_Model = $card_model;
            }
        );

        $output = $this->request(
            'POST', ['Cards', 'delete'], [
            'id' => '1'
            ]
        );

        $this->assertResponseCode(500);
        $this->assertContains(
            "Your card has NOT been deleted successfully.", 
            $output
        );
    }

    public function test_DeleteAPI_WhenNotInputId_500Error() 
    {
        $this->request(
            'POST', 
            ['Cards', 'delete']
        );
        $this->assertResponseCode(500);
    }

    public function test_DeleteAPI_WhenInputEmptyId_500Error() 
    {
        $this->request(
            'POST', 
            ['Cards', 'delete'], 
            [
                'id' => ''
            ]
        );
        $this->assertResponseCode(500);
    }

    public function test_DeleteAPI_WhenInputWRONGId_500Error() 
    {
        $this->request->setCallable(
            function ($CI) {
                $card_model = $this->getDouble(
                    'Card_Model', 
                    ['readCardById' => false]
                );
                $CI->Card_Model = $card_model;
            }
        );

        $output = $this->request(
            'POST', ['Cards', 'delete'], [
            'id' => 'WRONGID'
            ]
        );

        $this->assertResponseCode(500);
        $this->assertContains(
            "The id does not exist. Please use correct id.", 
            $output
        );
    }

    public function test_DeleteAPI_WhenAccessWithGetMethod_404Error() 
    {
        $this->request('GET', ['Cards', 'delete']);
        $this->assertResponseCode(404);
    }
}   