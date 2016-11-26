<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Lesson;
use App\transformer\LesonsTransformer;
use Illuminate\Http\Request;

use App\Http\Requests;
use Validator;

class LessonsController extends ApiController
{
    protected $lessonTransformer;

    public function __construct(LesonsTransformer $lessonTransformer)
    {
        $this->lessonTransformer = $lessonTransformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->get('limit') ?: 10;
            $lessons = Lesson::paginate($limit);

            return $this->respondWithPagination($lessons,
                ['lessons' => $this->lessonTransformer->transformCollection($lessons->all())]
            );
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
        try {
            $input = $request->only(['title', 'body']);
            //validate inputs
            $validator = Validator::make($input, [
                'title' => 'required|max:255',
                'body' => 'required|min:100'
            ]);
            //check if validation fails
            if ($validator->fails()) {
                return $this->setStatusCode(422)->respondWithError($validator->messages());
            } else {
                //add new lesson
                $lesson = Lesson::create($input);
                //Todo:: Add new type of respond to Api Controller for Success create
                return $this->setStatusCode(201)->respond([
                    'message' => 'The lesson has been created successfully.',
                    'status_code' => 201,
                    'data' => $this->respond($this->lessonTransformer->transform($lesson))
                ]);
            }
        } catch (Exception $e) {
            //return server errors
            return $this->setStatusCode(500)->respondWithError($e->messages());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $lesson = Lesson::with('tags')->find($id);
            if (!$lesson) {
                return $this->respondNotFound('This Lesson is not exist!');
            } else {
                return $this->respond($this->lessonTransformer->transform($lesson));
            }
        } catch (Exception $e) {
            return $this->setStatusCode(500)->respondWithError($e->messages());
        }
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
        try {
            $lesson = Lesson::find($id);
            if (!$lesson) {
                return $this->respondNotFound('This lesson is not exist!');
            } else {

                $input = $request->only(['title', 'body']);
                //validate inputs
                $validator = Validator::make($input, [
                    'title' => 'required|max:255',
                    'body' => 'required|min:100'
                ]);
                if ($validator->fails()) {
                    return $this->setStatusCode(422)->respondWithError($validator->messages());
                } else {
                    $lesson->update($input);
                    //Todo:: Add new type of respond to Api Controller for updated response
                    return $this->setStatusCode(200)->respond([
                        'message' => 'This lesson has been updated successfully!',
                        'status_code' => 200,
                        'update_data' => $lesson
                    ]);
                }
            }
        } catch (Exception $e) {
            return $this->setStatusCode(500)->respondWithError($e->messages());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $lesson = Lesson::find($id);
            if (!$lesson) {
                return $this->respondNotFound('This person is not exist!');
            } else {
                $lesson->delete();
                //Todo:: Add new type of respond to Api Controller for updated response
                return $this->setStatusCode(200)->respond([
                    'message' => 'This lesson has been deleted successfully!',
                    'status_code' => 101
                ]);
            }
        } catch (Exception $e) {
            return $this->setStatusCode(500)->respondWithError($e->messages());
        }
    }
}
