<?php

use LaravelFlare\Flare\Tests\BaseTest;
use Illuminate\Database\Eloquent\Model;
use LaravelFlare\Flare\Admin\AdminManager;
use LaravelFlare\Flare\Admin\Models\ModelAdmin;
use LaravelFlare\Flare\Admin\Models\ManagedModel;

class AdminManagerTest extends BaseTest
{
    public function test_get_admin_classes_returns_empty_array_when_admin_key_not_set()
    {
        $collection = new AdminManager();
        $this->assertEquals($collection->getAdminClasses(), []);
    }

    public function test_get_admin_classes_returns_empty_array_when_admin_key_is_set_and_config_exists_but_is_empty()
    {
        $collection = new ThisSampleCollection();
        $this->assertEquals($collection->getAdminClasses(), []);
    }

    public function test_get_admin_classes_returns_object_array_when_admin_key_is_set_and_config_exists_with_classes()
    {
        Config::set('flare.models', [
                ThisSampleAdmin::class
            ]);
        $collection = new ThisSampleCollection();
        $this->assertEquals($collection->getAdminClasses(), [(new ThisSampleAdmin)]);
    }

    public function test_get_admin_classes_returns_empty_array_when_admin_key_is_set_and_config_exists_with_invalid_classes()
    {
        Config::set('flare.models', [
                \LaravelFlare\Flare\Admin\Admin::class
            ]);
        $collection = new ThisSampleCollection();
        $this->assertEquals($collection->getAdminClasses(), []);
    }
}

class ThisSampleCollection extends AdminManager
{
    const ADMIN_KEY = 'models';
}

class ThisSampleAdmin extends ModelAdmin
{
    public static $icon = 'user';

    protected $managedModels = [
        ThisSampleManagedModel::class,
    ];
}

class ThisSampleManagedModel extends ManagedModel
{
    public $managedModel = ThisSampleModel::class;
}

class ThisSampleModel extends Model
{

}
