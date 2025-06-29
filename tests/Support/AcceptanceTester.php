<?php

declare(strict_types=1);

namespace App\Tests\Support;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    public function amAdmin(): void
    {
        $this->amHttpAuthenticated('admin', 'admin');
    }

    public function amUser(): void
    {
        $this->amHttpAuthenticated('NewUser', '123456789');
    }

    /**
     * Define custom actions here
     */
}
