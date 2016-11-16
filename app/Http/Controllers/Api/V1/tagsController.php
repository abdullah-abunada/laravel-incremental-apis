<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Lesson;
use App\Tag;
use App\transformer\TagsTransformer;
use Illuminate\Http\Request;

class tagsController extends ApiController
{
    protected $tagTransformer;

    /**
     * tagsController constructor.
     * @param TagsTransformer $tagsTransformer
     */
    public function __construct(TagsTransformer $tagsTransformer)
    {
        $this->tagTransformer = $tagsTransformer;
    }


    /**
     *Display a listing of the resource.
     *
     * @param Request $request
     * @param null $id
     * @return \Response
     */
    public function index(Request $request, $id = null)
    {
        try {
            if ($id) {
                $lesson = Lesson::find($id);
                if ($lesson) {
                    $tags = $lesson->tags;
                    return $this->respond(['tags' => $this->tagTransformer
                        ->transformCollection($tags->toArray())]);
                } else {
                    return $this->respondNotFound('This lesson is not exist!');
                }
            } else {

                $limit = $request->get('limit') ?: 10;
                $tags = Tag::paginate($limit);

                return $this->respondWithPagination($tags,
                    ['tags' => $this->tagTransformer->transformCollection($tags->all())]
                );
            }

        } catch (Exception $e) {
            return $this->setStatusCode(500)->respondWithError($e->messages());
        }
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
