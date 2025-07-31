<?php

namespace App\Tests\codeception\api\Test;

use App\Tests\codeception\ApiTester;
use Codeception\Attribute\DataProvider;
use Codeception\Example;
use Codeception\Util\HttpCode;

class TestControllerCest
{
    private const string EXIST_UUID = 'a931001e-56ff-4752-b3db-f7ed3544c385';
    private const string NON_EXIST_UUID = '6b27f9b1-1ba8-494d-8529-7ea4fe997e44';

    private bool $initialized = false;

    public function _before(ApiTester $I): void
    {
        if ($this->initialized) {
            return;
        }
//        To niżej zostaw!!

//        $I->useDatabase($_ENV['MONGODB_DBNAME']);
//
//        $I->deleteRecordsInDatabase('requests');
//        $I->deleteRecordsInDatabase('tests');
//
//        $I->insertFromJsonFile('tests', 'tests.json');

        $I->clearDb('requests');
        $I->clearDb('tests');
        $I->loadSqlFile('dev.tests.tests_insert.sql');

        $this->initialized = true;
    }

    # GET #

    public function testShouldReturnJsonWithOneTestObject(ApiTester $I): void
    {
        $I->sendGet(sprintf('api/tests/%s', self::EXIST_UUID));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseEquals(json_encode([
            "uuid" => self::EXIST_UUID,
            "name" => "cos",
            "number" => 12
        ]));
    }

    public function testShouldReturnJsonWithMultipleTestObject(ApiTester $I): void
    {
        $I->sendGet('api/tests');
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseEquals(json_encode([
            [
                "uuid" => "13f631a8-0f0c-46ce-a533-b3d00ac57e80",
                "name" => "cos",
                "number" => 1
            ],
            [
                "uuid" => self::EXIST_UUID,
                "name" => "cos",
                "number" => 12
            ]
        ]));
    }

    public function testShouldReturnNotFoundWhenUuidIsNotInDatabase(ApiTester $I): void
    {
        $I->sendGet(sprintf('api/tests/%s', self::NON_EXIST_UUID));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
        $I->seeResponseEquals(json_encode(["type" => "TEST_NOT_FOUND"]));
    }

    # PUT #

    public function testShouldUpdateRecord(ApiTester $I): void
    {
        $I->sendPut(sprintf('api/tests/%s', self::EXIST_UUID), json_encode(['name' => 'Paweł', 'number' => 100]));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    # GET after PUT #

    public function testShouldReturnJsonWithUpdatedRecord(ApiTester $I): void
    {
        $I->sendGet(sprintf('api/tests/%s', self::EXIST_UUID));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseEquals(json_encode([
            "uuid" => self::EXIST_UUID,
            "name" => "Paweł",
            "number" => 100
        ]));
    }

    private function provideExceptionUpdateQueryParameters(): array
    {
        return [
            [
                'uuid' => self::EXIST_UUID,
                'body' => [
                    'name' => uniqid(),
                    'number' => 0,
                ],
                'response' => '{"errors":{"number":["VALUE_IS_TOO_LOW"]}}',
                'code' => HttpCode::BAD_REQUEST,
            ],
            [
                'uuid' => self::EXIST_UUID,
                'body' => [
                    'name' => uniqid(),
                    'number' => 101,
                ],
                'response' => '{"errors":{"number":["VALUE_IS_TOO_HIGH"]}}',
                'code' => HttpCode::BAD_REQUEST,
            ]
        ];
    }

    #[DataProvider('provideExceptionUpdateQueryParameters')]
    public function testShouldReturnExceptionWhenTryToUpdateRecord(ApiTester $I, Example $example): void
    {
        $I->sendPut(sprintf('api/tests/%s', $example['uuid']), json_encode($example['body']));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs($example['code']);
        $I->seeResponseContains($example['response']);
    }

    # DELETE #

    public function testShouldDeleteRecord(ApiTester $I): void
    {
        $I->sendDelete(sprintf('api/tests/%s', self::EXIST_UUID));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    private function provideExceptionDeleteQueryParameters(): array
    {
        return [
//            [
//                'uuid' => '1312',
//                'response' => '{"errors":{"uuid":["INVALID_UUID"]}}',
//                'code' => HttpCode::BAD_REQUEST,
//            ],
            [
                'uuid' => '6b27f9b1-1ba8-494d-8529-7ea4fe997e44',
                'response' => '{"type":"TEST_NOT_FOUND"}',
                'code' => HttpCode::NOT_FOUND,
            ],
        ];
    }

    #[DataProvider('provideExceptionDeleteQueryParameters')]
    public function testShouldReturnNotFoundWhenTryToDeleteAndUuidIsNotInDatabase(ApiTester $I, Example $example): void
    {
        $I->sendDeleteAsJson(sprintf('api/tests/%s', $example['uuid']));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs($example['code']);
        $I->seeResponseContains($example['response']);
    }

    # POST #

    private function provideQueryParameters(): array
    {
        return [
            [
                'body' => [
                    'name' => uniqid(),
                    'number' => rand(1, 100),
                ],
            ],
        ];
    }

    #[DataProvider('provideQueryParameters')]
    public function testShouldCreateNewTestRecord(ApiTester $I, Example $example): void
    {
        $I->clearDb('requests');

        $I->sendPost('api/tests', json_encode($example['body']));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }

    private function provideExceptionCreateQueryParameters(): array
    {
        return [
            [
                'body' => [
                    'name' => uniqid(),
                    'number' => 0,
                ],
                'response' => '{"errors":{"number":["VALUE_IS_TOO_LOW"]}}',
            ],
            [
                'body' => [
                    'name' => uniqid(),
                    'number' => 101,
                ],
                'response' => '{"errors":{"number":["VALUE_IS_TOO_HIGH"]}}',
            ]
        ];
    }

    #[DataProvider('provideExceptionCreateQueryParameters')]
    public function testShouldReturnExceptionWhenTryToCreateNewTestRecord(ApiTester $I, Example $example): void
    {
        $I->clearDb('requests');

        $I->sendPost('api/tests', json_encode($example['body']));
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseContains($example['response']);
    }
}
