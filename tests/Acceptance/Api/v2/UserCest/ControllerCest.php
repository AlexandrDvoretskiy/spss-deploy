<?php

namespace AcceptanceTests\Api\v2\UserCest;

use App\Tests\Support\AcceptanceTester;
use Codeception\Util\HttpCode;


class ControllerCest
{
    public function testAddUserActionAsAdmin(AcceptanceTester $I): void
    {
        $I->amAdmin();
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/user/v2/', $this->getMethodParams());
        $I->canSeeResponseCodeIs(HttpCode::OK);
        $I->canSeeResponseMatchesJsonType(['id' => 'integer:>0']);
    }

    public function testAddUserActionAsUser(AcceptanceTester $I): void
    {
        $I->amUser();
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPost('/api/user/v2/', $this->getMethodParams());
        $I->canSeeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    private function getMethodParams(): array
    {
        return [
            "login" => "FunctionalTestUser222",
            "password" => "123456789",
            "roles" => ["ROLE_USER"]
        ];
    }
}