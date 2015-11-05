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
        return view('flare::admin.modelAdmin.index', [
                                                        'modelItems' => $this->model->get(),
                                                        'totals' => [
                                                            'all' => $this->model->get()->count(),
                                                            'with_trashed' => $this->model->withTrashed()->get()->count(),
                                                            'only_trashed' => $this->model->onlyTrashed()->get()->count(),
                                                        ],
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
        return view('flare::admin.modelAdmin.trashed', [
                                                        'modelItems' => $this->model->onlyTrashed()->get(),
                                                        'totals' => [
                                                            'all' => $this->model->get()->count(),
                                                            'with_trashed' => $this->model->withTrashed()->get()->count(),
                                                            'only_trashed' => $this->model->onlyTrashed()->get()->count(),
                                                        ],
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
        return view('flare::admin.modelAdmin.all', [
                                                    'modelItems' => $this->model->withTrashed()->get(),
                                                    'totals' => [
                                                        'all' => $this->model->get()->count(),
                                                        'with_trashed' => $this->model->withTrashed()->get()->count(),
                                                        'only_trashed' => $this->model->onlyTrashed()->get()->count(),
                                                    ],
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
        return view('flare::admin.modelAdmin.create', []);
    }

    /**
     * Receive new Model Entry Post Data, validate it and return user.
     * 
     * @return \Illuminate\Http\RedirectResponse
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

        event(new ModelView($this->modelAdmin));

        return view('flare::admin.modelAdmin.view', ['modelItem' => $this->modelAdmin->model]);
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

        return view('flare::admin.modelAdmin.edit', ['modelItem' => $this->modelAdmin->model]);
    }

    /**
     * Receive Model Entry Update Post Data, validate it and return user.
     * 
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\RedirectResponse
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
        if (isset($this->modelAdmin->softDeletingModel) && $this->modelAdmin->softDeletingModel) {
            $this->modelAdmin->findWithTrashed($modelitem_id);
        } else {
            $this->modelAdmin->find($modelitem_id);
        }

        return view('flare::admin.modelAdmin.delete', ['modelItem' => $this->modelAdmin->model]);
    }

    /**
     * Receive Model Entry Delete Post Data, validate it and return user.
     *
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postDelete($modelitem_id)
    {
        $this->modelAdmin->delete($modelitem_id);

        return redirect($this->modelAdmin->currentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->title().' was successfully removed.', 'dismissable' => false]]);
    }

    /**
     * Restore a ModelItem.
     *
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function getRestore($modelitem_id)
    {
        return view('flare::admin.modelAdmin.restore', ['modelItem' => $this->modelAdmin->model]);
    }

    /**
     * Process Restore ModelItem Request.
     *
     * @param int $page_id
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRestore($modelitem_id)
    {
        $this->modelAdmin->findOnlyTrashed($modelitem_id)->restore();

        return redirect($this->modelAdmin->currentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->title().' was successfully restored.', 'dismissable' => false]]);
    }

    /**
     * Clone a Page.
     *
     * @param int $modelitem_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function getClone($modelitem_id)
    {
        $this->modelAdmin->find($modelitem_id)->replicate($this->modelAdmin->excludeOnClone())->save();

        return redirect($this->modelAdmin->currentUrl())->with('notifications_below_header', [['type' => 'success', 'icon' => 'check-circle', 'title' => 'Success!', 'message' => 'The '.$this->modelAdmin->title().' was successfully cloned.', 'dismissable' => false]]);
    }
}
