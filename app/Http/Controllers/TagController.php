<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Acme\Transformers\TagTransformer;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use phpDocumentor\Reflection\DocBlock\Tag;

class TagController extends Controller
{
    protected $tagTransformer;
    /**
     * TagController constructor.
     */
    public function __construct(TagTransformer $tagTransformer)
    {
        $this->tagTransformer = $tagTransformer;
        $this->middleware("auth.api");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($taskId = null)
    {
        //problema 1, no retorna: paginació
        //$tag = Tag::all();
        $tag = $this->getTags($taskId);
        return $this->respond($this->tagTransformer->transformCollection($tag->all()));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tag = new tag();

        $this->saveTag($request, $tag);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $tag = Tag::findOrFail($id);

        //Es el mateix
        //$tag= Tag::where('id', $id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tag = Tag::findOrFail($id);
        $this->saveTag($request, $tag);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param $tag
     */
    public function saveTag(Request $request, $tag)
    {
        $tag->name = $request->name;
        $tag->save();
    }
}
