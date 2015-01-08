<?php

class QuestionnaireTest extends TestCase {

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testJoin()
    {
        $this->be(Member::find(1));
        $rs = $this->action('post', 'QuestionnaireController@postJoin', [
            'questionnaire_id' => 2,
            'question' => [
                3 => 10,
                4 => 15
            ],
        ]);

    }

}
