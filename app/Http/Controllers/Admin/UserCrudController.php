<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Repositories\EmpresaRepository;
use App\Repositories\RoleUserRepository;
use App\Repositories\UserRepository;
use App\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\PermissionManager\app\Http\Requests\UserStoreCrudRequest as StoreRequest;
// VALIDATION
use Backpack\PermissionManager\app\Http\Requests\UserUpdateCrudRequest as UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCrudController extends CrudController
{
    private $userRepository;
    private $empresaRepository;
    private $roleUserRepository;

    public function __construct(UserRepository $userRepository, EmpresaRepository $empresaRepository, RoleUserRepository $roleUserRepository)
    {
        $this->userRepository = $userRepository;
        $this->empresaRepository = $empresaRepository;
        $this->roleUserRepository = $roleUserRepository;
        parent::__construct();
    }

    public function setup()
    {
        $this->crud->setModel(config('backpack.permissionmanager.user_model'));
        $this->crud->setEntityNameStrings(trans('backpack::permissionmanager.user'), trans('backpack::permissionmanager.users'));
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/user');

        $this->crud->setColumns([
            [
                'name' => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type' => 'email',
            ],
        ]);

        $this->crud->addColumn([ // n-n relationship (with pivot table)
            'label' => trans('backpack::permissionmanager.roles'), // Table column heading
            'type' => 'select_multiple',
            'name' => 'roles', // the method that defines the relationship in your Model
            'entity' => 'roles', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "Backpack\PermissionManager\app\Models\Roles", // foreign key model
        ]);

        $this->crud->addFields([
            [
                'name' => 'name',
                'label' => trans('backpack::permissionmanager.name'),
                'type' => 'text',
            ],
            [
                'name' => 'email',
                'label' => trans('backpack::permissionmanager.email'),
                'type' => 'email',
            ],
            [
                'name' => 'password',
                'label' => trans('backpack::permissionmanager.password'),
                'type' => 'password',
            ],
            [
                'name' => 'password_confirmation',
                'label' => trans('backpack::permissionmanager.password_confirmation'),
                'type' => 'password',
            ],
//            [
//                'label'     => trans('backpack::permissionmanager.roles'),
//                'type'      => 'checklist',
//                'name'      => 'role',
//                'entity'    => 'role',
//                'attribute' => 'name',
//                'model'     => "Backpack\PermissionManager\app\Models\Role",
//                'pivot'     => true,
//            ],
            [
                // two interconnected entities
                'label' => trans('backpack::permissionmanager.user_role_permission'),
                'field_unique_name' => 'user_role_permission',
                'type' => 'checklist_dependency',
                'name' => 'roles_and_permissions', // the methods that defines the relationship in your Model
                'subfields' => [
                    'primary' => [
                        'label' => trans('backpack::permissionmanager.roles'),
                        'name' => 'roles', // the method that defines the relationship in your Model
                        'entity' => 'roles', // the method that defines the relationship in your Model
                        'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                        'attribute' => 'name', // foreign key attribute that is shown to user
                        'model' => "Backpack\PermissionManager\app\Models\Role", // foreign key model
                        'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                    'secondary' => [
                        'label' => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                        'name' => 'permissions', // the method that defines the relationship in your Model
                        'entity' => 'permissions', // the method that defines the relationship in your Model
                        'entity_primary' => 'roles', // the method that defines the relationship in your Model
                        'attribute' => 'name', // foreign key attribute that is shown to user
                        'model' => "Backpack\PermissionManager\app\Models\Permission", // foreign key model
                        'pivot' => true, // on create&update, do you need to add/delete pivot table entries?]
                        'number_columns' => 3, //can be 1,2,3,4,6
                    ],
                ],
            ],
        ]);
    }

    /**
     * Show the form for creating inserting a new row.
     *
     * @return Response
     */
    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = trans('backpack::crud.add').' '.$this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('admin.users.create', $this->data);
    }

    /**
     * Store a newly created resource in the database.
     *
     * @param StoreRequest $request - type injection used for validation using Requests
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $this->crud->hasAccessOrFail('create');

        // insert item in the db
        if ($request->input('password')) {
            $item = $this->crud->create(\Request::except(['redirect_after_save']));

            // now bcrypt the password
            $item->password = bcrypt($request->input('password'));
            $item->save();
        } else {
            $item = $this->crud->create(\Request::except(['redirect_after_save', 'password']));
        }

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
    }

    public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;

        $this->data['id'] = $id;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('admin.users.edit', $this->data);
    }

    public function update(UpdateRequest $request)
    {
        //encrypt password and set it to request
        $this->crud->hasAccessOrFail('update');

        $dataToUpdate = \Request::except(['redirect_after_save', 'password']);

        //encrypt password
        if ($request->input('password')) {
            $dataToUpdate['password'] = bcrypt($request->input('password'));
        }

        // update the row in the db
        $this->crud->update(\Request::get($this->crud->model->getKeyName()), $dataToUpdate);
        $this->roleUserRepository->deleteRoles(\Request::get('id'), \Request::get('roles_show')[0]);

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        // save the redirect choice for next time
        $this->setSaveAction();

        return $this->performSaveAction();
    }

    public function promotores() {
        $this->crud->denyAccess(['create', 'update', 'delete']);
        $this->crud->removeColumn('roles');
        $this->crud->removeColumn('permissions');
        $entries = $this->userRepository->getPromotores();

        $promotores =[];
        foreach ($entries as $entry) {
            $promotor = User::find($entry->id);
            $promotor->load('emppermission');
            $promotores[] = $promotor;
        }

        $this->data['crud'] = $this->crud;
        $this->data['title'] = ucfirst($this->crud->entity_name_plural);
        $this->data['entries'] = $promotores;

        return view('admin.users.promotores', $this->data);
    }

    public function getEmpresasDePromotor($promotor_id) {
        $empresas = $this->empresaRepository->getEmpresasPorUsuarioPermiso($promotor_id, 4);
        return json_encode(array('empresas' => $empresas));
    }
}
