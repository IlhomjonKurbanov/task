<?php

namespace tests\models;

use app\fixtures\User as UserFixture;
use app\models\SignupForm;

/**
 * Class SignupFormTest
 * @package tests\models
 */
class SignupFormTest extends \Codeception\Test\Unit
{

    /**
     * @var \_generated\UnitTesterActions
     */
    protected $tester;

    /**
     * @inheritdoc
     */
    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function testCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'some_username',
            'password' => 'some_password',
        ]);

        $user = $model->signup();

        expect($user)->isInstanceOf('app\models\User');

        expect($user->username)->equals('some_username');
        expect($user->validatePassword('some_password'))->true();
    }

    /**
     * @inheritdoc
     */
    public function testNotCorrectSignup()
    {
        $model = new SignupForm([
            'username' => 'troy.becker',
            'password' => 'some_password',
        ]);

        expect_not($model->signup());
        expect_that($model->getErrors('username'));
    }
}