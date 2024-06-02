<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentManagerController extends Controller
{
    protected $path;
    protected $pathRedirect;
    protected $name;

    protected $datatable;
    protected $model;
    protected $formRequest;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return app($this->datatable)->render($this->path.'.index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectAjax(Request $oRequest)
    {
        $this->oRepository->setReturnCollection(false);
        return $this->oRepository->select2($oRequest->all());
    }  
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'/form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {   
        $request   = app($this->formRequest);
        $inputs    = $request->all();
        
        $model = $this->model->create($inputs);
        
        foreach ($inputs as $key => $ids) {
            if (method_exists($model, $key) && $model->$key() instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany) {
                $model->$key()->sync($ids);
            }
        }
        
        if (!$request->is('api/*')) {
            return redirect($this->pathRedirect)->withOk("L'objet a été créé.");
        } else {
            return response()->json([
                'message'   => 'Ok',
                'id'        => $id,
                'input'     => $inputs
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if (!$request->is('api/*'))
        {
            $item = $this->model
                ->findOrFail($id);

            return view($this->path.'/form', compact('item'));
        }
        else
        {
            $aInput = $request->all();
            
            if (array_has($aInput, 'column') && count($aInput['column']) > 0)
            {
                $aField = $aInput['column'];
            }
            else
            {
                $aField = ['*'];
            }
            
            $oItem = $this->oRepository
                ->find($id, $aField);
            
            return response()->json($oItem, 200);
        }        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $request   = app($this->formRequest);
        $inputs    = $request->all();
        
        $model = $this->model
            ->findOrFail($id);
        
        $model->update($inputs);
        
        foreach ($inputs as $key => $ids) {
            if (method_exists($model, $key) && $model->$key() instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany) {
                $model->$key()->sync($ids);
            }
        }
        
        if (!$request->is('api/*'))
        {
            return redirect($this->pathRedirect)->withOk("L'objet a été modifié.");
        }
        else
        {
            return response()->json([
                'message'   => 'Ok',
                'id'        => $id,
                'input'     => $inputs
            ], 200);
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $this->model->destroy($id);
        
        if (!$request->is('api/*'))
        {
            return redirect($this->pathRedirect)->withOk("L'objet a été supprimé.");
        }
        else
        {
            return response()->json([
                'message'   => 'Ok',
                'id'        => $id
            ], 200);
        }
        
    }
}
