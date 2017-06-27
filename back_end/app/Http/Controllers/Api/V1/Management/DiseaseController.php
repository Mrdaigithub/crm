<?php

namespace App\Http\Controllers\Api\V1\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Management\Disease;
use Validator;
use Dingo\Api\Routing\Helpers;

class DiseaseController extends Controller
{
    use Helpers;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Disease::root()->getDescendants()->toHierarchy();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $diseases = [
            ['id'=>1, 'name' => 'root', 'children' => [
                ['id'=>2, 'name' => 'disease1', 'children' => [
                    ['id'=>3, 'name' => 'disease1-1'],
                    ['id'=>4, 'name' => 'disease1-2'],
                    ['id'=>5, 'name' => 'disease1-3'],
                ]],
                ['id'=>6, 'name' => 'disease2', 'children' => [
                    ['id'=>7, 'name' => 'disease2-1'],
                    ['id'=>8, 'name' => 'disease2-2'],
                    ['id'=>9, 'name' => 'disease2-3'],
                    ['id'=>10, 'name' => 'disease2-4'],
                ]],
                ['id'=>11, 'name' => 'disease3', 'children' => [
                    ['id'=>12, 'name' => 'disease3-1'],
                    ['id'=>13, 'name' => 'disease3-2'],
                    ['id'=>14, 'name' => 'disease3-3'],
                ]]
            ]]
        ];

        return response()->json(Disease::buildTree($diseases));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
