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
            ['id' => 1, 'name' => 'root', 'children' => [
                ['id' => 2, 'name' => 'disease1', 'children' => [
                    ['id' => 3, 'name' => 'disease1-1'],
                ]],
                ['id' => 4, 'name' => 'disease2', 'children' => [
                    ['id' => 5, 'name' => 'disease2-1'],
                    ['id' => 6, 'name' => 'disease2-2'],
                ]]
            ]]
        ];

        return response()->json(Disease::buildTree($diseases));
    }

    /**
     * * Store a newly created resource in storage.
     *
     * @param $pid
     * @param $name
     * @return \Illuminate\Http\Response
     */
    public function store($pid, $name)
    {
        $parameters = ['id'=>$pid, 'name'=>$name];
        if (Validator::make($parameters, ['id' => 'exists:diseases'])->fails()) $this->response->errorBadRequest(400021);
        if (Validator::make($parameters, ['name' => 'string'])->fails()) $this->response->errorBadRequest(400022);

        $c_node = Disease::find($parameters['id'])->children()->create(['name' => $parameters['name']]);
        return $c_node;
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
        $parameters = $request->all();
        $parameters['id'] = $id;
        if (Validator::make($parameters, ['id' => 'exists:diseases'])->fails()) $this->response->errorBadRequest(400021);
        if (Validator::make($parameters, ['name' => 'string'])->fails()) $this->response->errorBadRequest(400022);

        $node = Disease::find($parameters['id']);
        $node->name = $parameters['name'];
        if (!$node->save()) $this->response->errorInternal(500001);
        return $node;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parameters['id'] = $id;
        if (Validator::make($parameters, ['id' => 'exists:diseases'])->fails()) $this->response->errorBadRequest(400021);

        $node = Disease::find($id);
        if (count($node->children()->get())) $this->response->errorInternal(500003);
        $node->delete();
    }
}
