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
                ['name' => 'Console', 'url' => '/home/console'],
                ['name' => 'Rank', 'url' => '/home/rank'],
                ['name' => 'Patients', 'url' => '/home/patients'],
                ['name' => 'Users list', 'url' => '/home/users'],
                ['name' => 'Data', 'children' => [
                    ['name' => 'Total data', 'url' => '/home/data/total'],
                    ['name' => 'Users data', 'url' => '/home/data/users'],
                    ['name' => 'Diseases data', 'url' => '/home/data/diseases'],
                    ['name' => 'Channels data', 'url' => '/home/data/channels'],
                    ['name' => 'Doctors data', 'url' => '/home/data/doctors'],
                    ['name' => 'Patients data', 'url' => '/home/data/patients']
                ]],
                ['name' => 'Project info', 'children' => [
                    ['name' => 'Diseases management', 'url' => '/home/management/diseases'],
                    ['name' => 'Doctor management', 'url' => '/home/management/doctors'],
                    ['name' => 'Channel management', 'url' => '/home/management/channel'],
                    ['name' => 'Advisory management', 'url' => '/home/management/advisory'],
                ]],
                ['name' => 'System setting', 'children' => [
                    ['name' => 'Parameter setting', 'url' => '/home/setting/parameter'],
                    ['name' => 'log', 'url' => '/home/setting/log']
                ]]
            ]]
        ];
        return response()->json(Menu::buildTree($children));
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
