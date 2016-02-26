<?php

namespace LaravelFlare\Flare\Admin\Models;

use LaravelFlare\Flare\Events\ModelView;
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

        view()->share('modelAdmin', $this->modelAdmin);
    }

    /**
     * Index page for ModelAdmin.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        return view('flare::admin.modeladmin.index', [
                                                        'modelItems' => $this->modelAdmin->items(),
                                                        'totals' => $this->modelAdmin->totals(),
                                                    ]
                                                );
    }

    /**
     * Lists Trashed Model Items.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getTrashed()
    {
        if (!$this->modelAdmin->hasSoftDeleting()) {
            return $this->missingMethod();
        }

        return view('flare::admin.modeladmin.trashed', [
                                                        'modelItems' => $this->modelAdmin->onlyTrashedItems(),
                                                        'totals' => $this->modelAdmin->totals(),
                                                    ]
                                                );
    }

    /**
     * List All Model Items inc Trashed.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        if (!$this->modelAdmin->hasSoftDeleting()) {
            return $this->missingMethod();
        }

        return view('flare::admin.modeladmin.all', [
                                                        'modelItems' => $this->modelAdmin->allItems(),
                                                        'totals' => $this->modelAdmin->totals(),
                                                    ]
                                            );
    }

    /**
     * Create a new Model Entry from ModelAdmin Create Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        if (!$this->modelAdmin->hasCreating()) {
            return $this->missingMethod();
        }

        return view('flare::admin.modeladmin.create', []);
    }

    /**
     * Receive new Model Entry Post Data, validate it and return user.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(ModelCreateRequest $request)
    {
        if (!$this->modelAdmin->hasCreating()) {
            return $this->missingMethod();
        }

        $this->modelAdmin->create();

        return redirect($this->modelAdmin->currentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->getTitle().' was successfully created.', 'dismissable' => false]]);
    }

    /**
     * View a Model Entry from ModelAdmin View Page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function getView($modelitemId)
    {
        if (!$this->modelAdmin->hasViewing()) {
            return $this->missingMethod();
        }

        $this->modelAdmin->find($modelitemId);

        event(new ModelView($this->modelAdmin));
        
        return view('flare::admin.modeladmin.view', ['modelItem' => $this->modelAdmin->model]);
    }

    /**
     * Edit Model Entry from ModelAdmin Edit Page.
     *
     * @param int $modelitemId
     * 
     * @return \Illuminate\Http\Response
     */
    public function getEdit($modelitemId)
    {
        if (!$this->modelAdmin->hasEditting()) {
            return $this->missingMethod();
        }

        $this->modelAdmin->find($modelitemId);

        return view('flare::admin.modeladmin.edit', ['modelItem' => $this->modelAdmin->model]);
    }

    /**
     * Receive Model Entry Update Post Data, validate it and return user.
     * 
     * @param int $modelitemId
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit(ModelEditRequest $request, $modelitemId)
    {
        if (!$this->modelAdmin->hasEditting()) {
            return $this->missingMethod();
        }

        $this->modelAdmin->edit($modelitemId);

        return redirect($this->modelAdmin->currentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->getTitle().' was successfully updated.', 'dismissable' => false]]);
    }

    /**
     * Delete Model Entry from ModelAdmin Delete Page.
     *
     * @param int $modelitemId
     * 
     * @return \Illuminate\Http\Response
     */
    public function getDelete($modelitemId)
    {
        if (!$this->modelAdmin->hasDeleting()) {
            return $this->missingMethod();
        }

        if ($this->modelAdmin->hasSoftDeleting()) {
            $this->modelAdmin->findWithTrashed($modelitemId);
        } else {
            $this->modelAdmin->find($modelitemId);
        }

        return view('flare::admin.modeladmin.delete', ['modelItem' => $this->modelAdmin->model]);
    }

    /**
     * Receive Model Entry Delete Post Data, validate it and return user.
     *
     * @param int $modelitemId
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDelete($modelitemId)
    {
        if (!$this->modelAdmin->hasDeleting()) {
            return $this->missingMethod();
        }

        $this->modelAdmin->delete($modelitemId);

        return redirect($this->modelAdmin->currentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->getTitle().' was successfully removed.', 'dismissable' => false]]);
    }

    /**
     * Restore a ModelItem.
     *
     * @param int $modelitemId
     * 
     * @return \Illuminate\Http\Response
     */
    public function getRestore($modelitemId)
    {
        if (!$this->modelAdmin->hasSoftDeleting()) {
            return $this->missingMethod();
        }

        return view('flare::admin.modeladmin.restore', ['modelItem' => $this->modelAdmin->model]);
    }

    /**
     * Process Restore ModelItem Request.
     *
     * @param int $page_id
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRestore($modelitemId)
    {
        if (!$this->modelAdmin->hasSoftDeleting()) {
            return $this->missingMethod();
        }

        $this->modelAdmin->restore($modelitemId);

        return redirect($this->modelAdmin->currentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->getTitle().' was successfully restored.', 'dismissable' => false]]);
    }

    /**
     * Clone a Page.
     *
     * @param int $modelitemId
     * 
     * @return \Illuminate\Http\Response
     */
    public function getClone($modelitemId)
    {
        if (!$this->modelAdmin->hasCloning()) {
            return $this->missingMethod();
        }

        $this->modelAdmin->find($modelitemId)->replicate($this->modelAdmin->excludeOnClone())->save();

        return redirect($this->modelAdmin->currentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->getTitle().' was successfully cloned.', 'dismissable' => false]]);
    }
}
