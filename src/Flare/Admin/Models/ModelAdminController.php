<?php

namespace LaravelFlare\Flare\Admin\Models;

use LaravelFlare\Flare\Events\ViewEvent;
use LaravelFlare\Flare\Admin\AdminManager;
use LaravelFlare\Flare\Http\Requests\ModelEditRequest;
use LaravelFlare\Flare\Http\Requests\ModelCreateRequest;
use LaravelFlare\Flare\Http\Controllers\FlareController;

class ModelAdminController extends FlareController
{
    /**
     * ModelAdmin instance which has been resolved.
     * 
     * @var ModelAdmin
     */
    protected $modelAdmin;

    /**
     * Model instance.
     * 
     * @var Model
     */
    protected $model;

    /**
     * __construct.
     * 
     * @param AdminManager $adminManager
     */
    public function __construct(AdminManager $adminManager)
    {
        // Must call parent __construct otherwise 
        // we need to redeclare checkpermissions
        // middleware for authentication check
        parent::__construct($adminManager);

        $this->middleware('checkmodelfound', ['only' => ['getView', 'edit', 'delete']]);

        $this->modelAdmin = $this->adminManager->getAdminInstance();
        $this->model = $this->modelAdmin->model();
    }

    /**
     * Index page for ModelAdmin.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('flare::admin.modelAdmin.index', ['modelAdmin' => $this->modelAdmin]);
    }

    /**
     * Create a new Model Entry from ModelAdmin Create Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        return view('flare::admin.modelAdmin.create', ['modelAdmin' => $this->modelAdmin]);
    }

    /**
     * Receive new Model Entry Post Data, validate it and return user.
     * 
     * @return \Illuminate\Http\Response
     */
    public function postCreate(ModelCreateRequest $request)
    {
        $this->modelAdmin->create();

        return redirect($this->modelAdmin->currentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->title().' was successfully created.', 'dismissable' => false]]);
    }

    /**
     * View a Model Entry from ModelAdmin View Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getView($modelitem_id)
    {
        $this->modelAdmin->find($modelitem_id);

        event(new ViewEvent($this->modelAdmin));

        return view('flare::admin.modelAdmin.view', [
            'modelAdmin' => $this->modelAdmin,
            'modelItem' => $this->modelAdmin->model,
        ]);
    }

    /**
     * Edit Model Entry from ModelAdmin Edit Page.
     *
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function getEdit($modelitem_id)
    {
        $this->modelAdmin->find($modelitem_id);

        return view('flare::admin.modelAdmin.edit', [
            'modelAdmin' => $this->modelAdmin,
            'modelItem' => $this->modelAdmin->model,
        ]);
    }

    /**
     * Receive Model Entry Update Post Data, validate it and return user.
     * 
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function postEdit(ModelEditRequest $request, $modelitem_id)
    {
        $this->modelAdmin->edit($modelitem_id);

        return redirect($this->modelAdmin->currentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->title().' was successfully updated.', 'dismissable' => false]]);
    }

    /**
     * Delete Model Entry from ModelAdmin Delete Page.
     *
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function getDelete($modelitem_id)
    {
        $this->modelAdmin->find($modelitem_id);

        return view('flare::admin.modelAdmin.delete', [
            'modelAdmin' => $this->modelAdmin,
            'modelItem' => $this->modelAdmin->model,
        ]);
    }

    /**
     * Receive Model Entry Delete Post Data, validate it and return user.
     *
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function postDelete($modelitem_id)
    {
        $this->modelAdmin->delete($modelitem_id);

        return redirect($this->modelAdmin->currentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->title().' was successfully removed.', 'dismissable' => false]]);
    }
}
