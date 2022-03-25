<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\UserResources;

class UserController extends apiController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
//        return response(User::paginate(10), 200);
        $offset = $request->has('offset') ? $request->query('offset') : 0;
        $limit = $request->has('limit') ? $request->query('limit') : 10;
        $qb = User::query();
        if ($request->has('q'))
            $qb->where('name', 'like', '%' . $request->query('q') . '%');
        if ($request->has('sortBy'))
            $qb->orderBy($request->query('sortBy'), $request->query('sort'));
        $data = $qb->offset($offset)->limit($limit)->get();
//        $data->each(function ($item) {
//            $item->setAppends(['full_name']);
//        });
        $data->each->setAppends(['full_name']);
        return response($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return Response
     */
    public function store(UserStoreRequest $request)
    {
        /*
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'name' => 'required|string|max:50',
            'password' => 'required',
        ]);

        if ($validator->fails())
            return $this->apiResponse(ResultType::Error, $validator->errors(), 'Validation error!', 422); // 400 Bad Request yada 422 unprocessible content
        */

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt($request->password);
        $user->remember_token = Str::random(10);
        $user->save();

        /*
        return response([
            'data' => $user,
            'message' => 'User successfully created!'
        ], 201);
        */
        return $this->apiResponse(ResultType::Success, $user, 'User successfully created!', JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    // public function show($id)
    {
        // $user = User::find($id);
        return $this->apiResponse(ResultType::Success, $user, 'User successfully founded!', JsonResponse::HTTP_OK);

        /*
        if ($user)
            // return response($user, 200);
            return $this->apiResponse(ResultType::Success, $user, 'User successfully founded!', JsonResponse::HTTP_OK);
        else
            return response(['message' => 'User not found!'], 404);
        */

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return \response([
            'data' => $user,
            'message' => 'User successfully updated!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return \response(['message' => 'User successfully deleted!'], 200);
    }

    public function custom1()
    {
        /*
        $user = User::find(2);
        //return new UserResources($user);
        return response(new UserResources($user), 200);
*/

         $users = User::all();
         return UserResources::collection($users);
/*
        return UserResources::collection($users)->additional([
            'meta' => [
                'total' => $users->count(),
                'custom' => 'value'
            ]
        ]);
        */
    }

    public function custom2() {
        $users = User::all();
        //return new UserCollection($users);
        return UserResources::collection($users)->additional([
            'meta' => [
                'total' => $users->count(),
                'custom' => 'value'
            ]
        ]);
    }
}
