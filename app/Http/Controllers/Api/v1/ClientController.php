<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Client::get();
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
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'string|required',
            'age' => 'integer|required',
            'email' => 'nullable|email:rfc|max:255',
            'birthdate' => 'required|date_format:Y-m-d',
            'status' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            response($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        return response([
            'message' => 'The client has been created.',
            'client' => Client::create($data)
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        if(!isset($client)){
            return response([
                'message' => 'The client is not registered.'
            ], Response::HTTP_CONFLICT);
        }

        return response($client, Response::HTTP_OK);
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
        $data = $request->all();
        $validator = Validator::make($data, [
            'id' => 'integer|required|exists:clients',
            'name' => 'string|required',
            'age' => 'integer|required',
            'email' => 'nullable|email:rfc|max:255',
            'birthdate' => 'required|date_format:Y-m-d',
            'status' => 'required|boolean'
        ]);
        if ($validator->fails()) {
            response($validator->messages(), Response::HTTP_BAD_REQUEST);
        }

        // Crear cliente
        $client = Client::find($id);
        $client->fill($data);
        $client->save();

        return response([
            'message' => 'The client has been modified.',
            'client' => Client::create($data)
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        if(!isset($client)){
            return response([
                'message' => 'The client is not registered.'
            ], Response::HTTP_CONFLICT);
        }

        return response([
            'message' => 'The client has been deleted.'
        ], Response::HTTP_OK);
    }
}
