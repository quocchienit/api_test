<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $users,
            ]);
        }

        return view('users.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function store(Request $request)
    {
        try {

            $post = $request->all();
            if (null !== $request->get('password')) {
                $post['password'] = Hash::make($request->get('password'));
            }
            $validate = User::validate($request, $post);

            if ($validate['status']) {
                $user = User::create($post);
                $result = $user->toArray();

            } else {
                $result = $validate['errors'];
            }

            $response = [
                'data' => $result,
                'errors' => !$validate['status'],
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['data']);
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                ]);
            }

            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $user,
            ]);
        }

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        // return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string            $id
     *
     * @return Response
     *
     */
    public function update(Request $request, $id)
    {
        try {

            $post = $request->all();
            if (null !== $request->get('password')) {
                $post['password'] = Hash::make($request->get('password'));
            }
            $validate = User::validate($request, $post);

            if ($validate['status']) {
                $user = User::find($id);
                $user->fill($post);
                $user->save();
                $result = $user->toArray();

            } else {
                $result = $validate['errors'];
            }

            $response = [
                'data' => $result,
                'errors' => !$validate['status'],
            ];

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['data']);
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage(),
                ]);
            }

            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = User::destroy($id);

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'user deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'user deleted.');
    }
}
