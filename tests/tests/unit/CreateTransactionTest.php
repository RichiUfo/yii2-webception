<?php

namespace frontend\modules\accounting\tests\tests\unit;

use frontend\modules\accounting\models\Transaction;

class CreateTransactionTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {
        $transaction = new Transaction;
    }

}