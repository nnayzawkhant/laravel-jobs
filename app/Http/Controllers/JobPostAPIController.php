<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class JobPostAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = JobPost::with('author')->paginate();

        return response()->json([
            'success' => 'true',
            'message' => 'Data retrieved successfully',
            'data' => $posts,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'company' => 'required',
            'category' => 'required',
            'description' => 'required'
        ]);

        if( $validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $form_data = $request->all();
        $form_data['author'] = auth()->user()->id;

        JobPost::create($form_data);

        return response()->json([
            'success' => 'true',
            'message' => 'Data saved successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobpost = JobPost::where("id",$id)->with('author')->get();

        return response()->json([
            'success' => 'true',
            'message' => 'Data retrieved successfully',
            'data' => $jobpost,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'company' => 'required',
            'category' => 'required',
            'description' => 'required'
        ]);

        if( $validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        $form_data = $request->only('title', 'company', 'company_logo', 'category', 'salary', 'description');
        $result = JobPost::where(["id" => $id])->update($form_data);

        return response()->json([
            'success' => $result ? true : false,
            'message' => $result ? 'Data updated successfully' : 'Data update failure !!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = JobPost::destroy($id);

        return response()->json([
            'success' => $result ? true : false,
            'message' => $result ? 'Data deleted successfully' : "Data deleted failure !!",
        ]);
    }
}
