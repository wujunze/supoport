<?php

namespace winwin\support\validation;

use winwin\support\TestCase;

class ValidatorFactoryTest extends TestCase
{
    public function createValidatorFactory()
    {
        return $validatorFactory = new ValidatorFactory([
            'bank_no' => new validators\BankNoValidator(),
            'id_card' => new validators\IdCardValidator(),
            'mobile' => new validators\MobileValidator(),
        ]);
    }

    /**
     * @dataProvider forms
     */
    public function testCreate($data, $rules, $result, $errors)
    {
        $validator = $this->createValidatorFactory()->create($data);
        $validator->rules($rules);
        if ($result) {
            $this->assertTrue($validator->validate());
        } else {
            $this->assertFalse($validator->validate());
            // var_export($validator->errors());
            $this->assertEquals($errors, $validator->errors());
        }
    }

    public function forms()
    {
        return [
            [['mobile' => '18600919133'], ['mobile' => [['mobile']]], true, null],
            [['mobile' => '160091913'], ['mobile' => [['mobile']]], false, ['mobile' => ['Mobile 不正确']]],
            [['id_card' => '420325199008040158'], ['id_card' => [['id_card']]], true, null],
            [['id_card' => '42032519900804015X'], ['id_card' => [['id_card']]], false, ['id_card' => ['Id Card 不正确']]],
            [['bank_no' => '6222083202007600451'], ['bank_no' => [['bank_no']]], true, null],
            [['bank_no' => '6222083202007600441'], ['bank_no' => [['bank_no']]], false, ['bank_no' => ['Bank No 不正确']]],
        ];
    }
}
