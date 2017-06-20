<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

use Illuminate\Http\Request;
use App\Models\Menu;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Menu::root()->getDescendants()->toHierarchy();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $children = [
            ['name' => 'root', 'children' => [
                ['name' => 'Console', 'url' => '/home'],
                ['name' => 'Rank', 'url' => '/rank'],
                ['name' => 'Patients', 'url' => '/patient'],
                ['name' => 'Patient track', 'children' => [
                    ['name' => 'Patient track list', 'url' => '/patient/track/list'],
                    ['name' => 'My track', 'url' => '/patient/track/my'],
                    ['name' => 'Track task', 'url' => '/patient/track/task'],
                ]],
                ['name' => 'Project info', 'children' => [
                    ['name' => 'Hospital management', 'url' => '/project/hospitals'],
                    ['name' => 'Diseases management', 'url' => '/patient/diseases'],
                    ['name' => 'Doctor management', 'url' => '/patient/doctors'],
                    ['name' => 'Channel management', 'url' => '/patient/channel'],
                    ['name' => 'Advisory management', 'url' => '/patient/advisory'],
                ]],
                ['name' => 'Data', 'children' => [
                    ['name' => 'Map data', 'url' => '/data/map'],
                    ['name' => 'Group data', 'url' => '/data/group'],
                    ['name' => 'Doctor data', 'url' => '/patient/doctors'],
                    ['name' => 'Performance data', 'url' => '/patient/performance'],
                    ['name' => 'Report data', 'url' => '/patient/report'],
                ]],
                ['name' => 'System setting', 'children' => [
                    ['name' => 'Parameter setting', 'url' => '/setting/parameter'],
                    ['name' => 'log', 'url' => '/setting/log']
                ]],
                ['name' => 'Users list', 'url' => '/users']
            ]]
        ];

        return response()->json(Menu::buildTree($children));


//        $root = Menu::root();
//        $node = Menu::where('name','System setting')->get();
//        return $node;
//        return response()->json(


//            $root
//                ->descendants()
//                ->withoutNode(Menu::where('name', 'Performance data')->first())
//                ->withoutNode(Menu::where('name', 'Report data')->first())
//                ->withoutNode(Menu::where('name', 'System setting')->first())
//                ->get()->toHierarchy());


//        $permission = Permission::where('name', $request['p_name'])->first();
//        $role = Role::where('name', $request['r_name'])->first();
//        $user = User::where('username', 'root')->first();
//        return json_encode($user->can('Admin/Flag/add_flag'));
//        return $role->attachPermission($permission);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
