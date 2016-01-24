<?php

use LaravelFlare\Flare\Admin\Admin;
use LaravelFlare\Flare\Tests\BaseTest;

class AbstractAdminTest extends BaseTest
{
    public function test_get_class_short_name()
    {
        $stub = $this->getMockForAbstractClass(Admin::class, [], 'SampleClassName');

        $reflection = new ReflectionClass($stub);

        $this->assertEquals($stub->shortName(), $reflection->getshortName());
        $this->assertEquals($stub->shortName(), 'SampleClassName');
    }

    public function test_convert_classname_to_title_when_no_title_defined()
    {
        $testAndResultArray = [
                                'Admin' => 'Admin',
                                'lowercase' => 'Lowercase',
                                'SampleAdmin' => 'Sample Admin',
                                'UPPERCASE' => 'U P P E R C A S E',
                                'lowercaseClassName' => 'Lowercase Class Name',
                                'AnotherAdminSection' => 'Another Admin Section',
                                'snake_case_classname' => 'Snake Case Classname',
                                'snakes_and_CamelCase' => 'Snakes And  Camel Case',
                            ];

        foreach ($testAndResultArray as $testClassName => $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], $testClassName);

            $this->assertEquals($stub->title(), $expectedResult);
        }
    }

    public function test_title_returns_defined_title_when_defined()
    {
        $testAndResultArray = [
                                '012' => '012',
                                'User' => 'User',
                                'Fish' => 'Fish',
                                'Admin' => 'Admin',
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
                                'Users' => 'Users',
                                'Admin' => 'Admins',
                                'photo' => 'Photos',
                                'Photo' => 'Photos',
                                'Model' => 'Models',
                                'photos' => 'Photos',
                                'Photos' => 'Photos',
                                'Finance' => 'Finances',
                            ];

        foreach ($testAndResultArray as $testClassName => $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], $testClassName);

            $this->assertEquals($stub->pluralTitle(), $expectedResult);
        }
    }

    public function test_plural_title_returns_defined_plural_title_when_defined()
    {
        $testAndResultArray = [
                                '012' => '012',
                                'Fish' => 'Fish',
                                'Users' => 'Users',
                                'Admins' => 'Admins',
                                'Finances' => 'Finances',
                                'Symbol & Space' => 'Symbol & Space',
                            ];

        foreach ($testAndResultArray as $definedPluralTitle => $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], 'SampleClassName');

            $reflection = new ReflectionClass($stub);
            $reflection_property = $reflection->getProperty('pluralTitle');
            $reflection_property->setAccessible(true);
            $reflection_property->setValue($stub, $definedPluralTitle);

            $this->assertEquals($stub->pluralTitle(), $expectedResult);

            $reflection_property->setValue($stub, null); // Need to reset this afterwards.
        }
    }

    public function test_classname_is_converted_to_title_and_is_returned_plurally_in_url_prefix()
    {
        $testAndResultArray = [
                                'Users' => 'users',
                                'Admin' => 'admins',
                                'photo' => 'photos',
                                'Photo' => 'photos',
                                'Model' => 'models',
                                'photos' => 'photos',
                                'Photos' => 'photos',
                                'Finance' => 'finances',
                                'SampleModel' => 'sample-models',
                                'SampleModels' => 'sample-models',
                                'lowercase_AndCamels' => 'lowercase-and-camels',
                            ];

        foreach ($testAndResultArray as $testClassName => $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], $testClassName);

            $this->assertEquals($stub->urlPrefix(), $expectedResult);
        }
    }

    public function test_defined_plural_title_is_converted_to_url_prefix()
    {
        $testAndResultArray = [
                                'users' => 'users',
                                'Admins' => 'admins',
                                'Some Finance' => 'some-finance',
                                'somefinances' => 'somefinances',
                                'Some Finances' => 'some-finances',
                                'Symbol & Space' => 'symbol-space',
                            ];

        foreach ($testAndResultArray as $definedPluralTitle => $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], 'SampleClassName');

            $reflection = new ReflectionClass($stub);
            $reflection_property = $reflection->getProperty('pluralTitle');
            $reflection_property->setAccessible(true);
            $reflection_property->setValue($stub, $definedPluralTitle);

            $this->assertEquals($stub->urlPrefix(), $expectedResult);

            $reflection_property->setValue($stub, null); // Need to reset this afterwards.
        }
    }

    public function test_defined_url_prefix_is_returned_by_url_prefix()
    {
        $testAndResultArray = [
                                'Admin',
                                'users',
                                'Models',
                                'perhaps123',
                                'Another-Example',
                                'user-defined-prefix',
                                'mix-and_match_or-dont',
                                'several_different_separators',
                            ];

        foreach ($testAndResultArray as $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], 'SampleClassName');

            $reflection = new ReflectionClass($stub);
            $reflection_property = $reflection->getProperty('urlPrefix');
            $reflection_property->setAccessible(true);
            $reflection_property->setValue($stub, $expectedResult);

            $this->assertEquals($stub->urlPrefix(), $expectedResult);

            $reflection_property->setValue($stub, null); // Need to reset this afterwards.
        }
    }

    public function test_full_url_is_returned_using_classname_to_generate_url_prefix()
    {
        $testAndResultArray = [
                                'Users' => 'users',
                                'Admin' => 'admins',
                                'photo' => 'photos',
                                'Photo' => 'photos',
                                'Model' => 'models',
                                'photos' => 'photos',
                                'Photos' => 'photos',
                                'Finance' => 'finances',
                                'SampleModel' => 'sample-models',
                                'SampleModels' => 'sample-models',
                                'lowercase_AndCamels' => 'lowercase-and-camels',
                            ];

        foreach ($testAndResultArray as $testClassName => $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], $testClassName);

            $expectedResult = url(\Flare::config('admin_url').'/'.$expectedResult);

            $this->assertEquals($stub->url(), $expectedResult);
        }
    }

    public function test_full_url_is_returned_using_defined_plural_title_to_generate_url_prefix()
    {
        $testAndResultArray = [
                                'users' => 'users',
                                'Admins' => 'admins',
                                'Some Finance' => 'some-finance',
                                'somefinances' => 'somefinances',
                                'Some Finances' => 'some-finances',
                                'Symbol & Space' => 'symbol-space',
                            ];

        foreach ($testAndResultArray as $definedPluralTitle => $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], 'SampleClassName');

            $reflection = new ReflectionClass($stub);
            $reflection_property = $reflection->getProperty('pluralTitle');
            $reflection_property->setAccessible(true);
            $reflection_property->setValue($stub, $definedPluralTitle);

            $expectedResult = url(\Flare::config('admin_url').'/'.$expectedResult);

            $this->assertEquals($stub->url(), $expectedResult);

            $reflection_property->setValue($stub, null); // Need to reset this afterwards.
        }
    }

    public function test_full_url_is_returned_using_defined_url_prefix()
    {
        $testAndResultArray = [
                                'Admin',
                                'users',
                                'Models',
                                'perhaps123',
                                'Another-Example',
                                'user-defined-prefix',
                                'mix-and_match_or-dont',
                                'several_different_separators',
                            ];

        foreach ($testAndResultArray as $expectedResult) {
            $stub = $this->getMockForAbstractClass(Admin::class, [], 'SampleClassName');

            $reflection = new ReflectionClass($stub);
            $reflection_property = $reflection->getProperty('urlPrefix');
            $reflection_property->setAccessible(true);
            $reflection_property->setValue($stub, $expectedResult);

            $expectedResult = url(\Flare::config('admin_url').'/'.$expectedResult);

            $this->assertEquals($stub->url(), $expectedResult);

            $reflection_property->setValue($stub, null); // Need to reset this afterwards.
        }
    }

    public function test_current_url()
    {
    }

    public function test_relative_current_url()
    {
    }
}
