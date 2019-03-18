<?php namespace App\Tests;
use App\Entity\User;

use App\Tests\FunctionalTester;

// vendor/bin/codecept run functional UserCest --debug
class UserCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function tryToTest(FunctionalTester $I)
    {
        $I->amOnPage('/user');
        $I->fillField(['css'=>'#user_name'], 'foobar');
        $I->click(['css'=>'#user_submit']);
        // Same result:
        // $I->submitForm(['name'=>'user'], array(
        //     'user' => array(
        //         'name' => 'foobar'
        //     )
        // ));
        $I->see('This value should be identical to string "foo".');
        // If you remove the next two lines, the bug does not appear (i.e. the user's name is not changed to "foobar"):
        $user = $I->grabEntityFromRepository(User::class, ['id'=>1]);
        $I->assertNull($user->getName());
    }
}
