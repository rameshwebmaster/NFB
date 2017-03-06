<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TransactionTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_a_transaction_has_amount()
    {
        $transaction = factory(\App\Transaction::class)->create(['amount' => 45000, 'type' => 'income']);

        $this->assertEquals($transaction->amount, 45000);
    }
}
