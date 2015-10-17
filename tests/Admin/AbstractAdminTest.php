<?php

use LaravelFlare\Flare\Admin\Admin;
use LaravelFlare\Flare\Tests\BaseTest;

class AbstractAdminTest extends BaseTest
{
    public function test_convert_classname_to_title_when_no_title_defined()
    {
        $testAndResultArray = [
                                'Admin' => 'Admin',
                                'SampleAdmin' => 'Sample Admin',
                                'AnotherAdminSection' => 'Another Admin Section',
                                'lowercaseClassName' => 'Lowercase Class Name',
                                'snake_case_classname' => 'Snake Case Classname',
                                'snakes_and_CamelCase' => 'Snakes And  Camel Case',
                                'lowercase' => 'Lowercase',
                                'UPPERCASE' => 'U P P E R C A S E'
                                ];

        foreach ($testAndResultArray as $testClassName => $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], $testClassName);

            $this->assertEquals($stub->title(), $expectedResult);
        }
    }    

    public function test_title_returns_defined_title_when_defined()
    {
        $testAndResultArray = [
                                'Admin' => 'Admin',
                                'User' => 'User',
                                'Fish' => 'Fish',
                                '012' => '012',
                                'Symbol & Space' => 'Symbol & Space',
                                ];

        foreach ($testAndResultArray as $testClassName => $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], 'SampleClassName');

            $reflection = new ReflectionClass($stub);
            $reflection_property = $reflection->getProperty('title');
            $reflection_property->setAccessible(true);
            $reflection_property->setValue($stub, $testClassName);

            $this->assertEquals($stub->title(), $expectedResult);

            $reflection_property->setValue($stub, null); // Need to reset this afterwards.
        }
    }

    public function test_classname_is_converted_to_title_and_is_returned_plural()
    {
        $testAndResultArray = [
                                'Admin' => 'Admins',
                                'Users' => 'Users',
                                'Finance' => 'Finances',
                                'photo' => 'Photos',
                                'Photo' => 'Photos',
                                'photos' => 'Photos',
                                'Photos' => 'Photos',
                                'Model' => 'Models',
                                ];

        foreach ($testAndResultArray as $testClassName => $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], $testClassName);

            $this->assertEquals($stub->pluralTitle(), $expectedResult);
        }
    }

    public function test_plural_title_returns_defined_plural_title_when_defined()
    {
        $testAndResultArray = [
                                'Admins' => 'Admins',
                                'Users' => 'Users',
                                'Finances' => 'Finances',
                                'Fish' => 'Fish',
                                '012' => '012',
                                'Symbol & Space' => 'Symbol & Space',
                            ];

        foreach ($testAndResultArray as $testClassName => $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], 'SampleClassName');

            $reflection = new ReflectionClass($stub);
            $reflection_property = $reflection->getProperty('pluralTitle');
            $reflection_property->setAccessible(true);
            $reflection_property->setValue($stub, $testClassName);

            $this->assertEquals($stub->pluralTitle(), $expectedResult);

            $reflection_property->setValue($stub, null); // Need to reset this afterwards.
        }
    }
}