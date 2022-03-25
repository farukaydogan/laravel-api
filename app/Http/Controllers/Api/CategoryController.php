<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $offset = $request->has('offset') ? $request->query('offset') : 0;
        $limit = $request->has('limit') ? $request->query('limit') : 10;

        $qb = Category::query();
        if ($request->has('q'))
            $qb->where('name', 'like', '%' . $request->query('q') . '%');
        if ($request->has('sortBy'))
            $qb->orderBy($request->query('sortBy'), $request->query('sort', 'DESC'));

        $data = $qb->offset($offset)->limit($limit)->get();

//        $data=Category::paginate(10);
        // return response($data, 200);
        return $this->apiResponse(ResultType::Success, $data, 'Categories successfully fetched!', 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->slug = \Illuminate\Support\Str::slug($request->name, '-');
        $category->save();
        /*return response([
            'data' => $category,
            'message' => 'Category successfully created!'
        ], 201);
        */
        return $this->apiResponse(ResultType::Success, $category, 'Category successfully created!', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return Response
     */
//    public function show(Category $category)
    public function show($id)
    {
        $category = Category::find($id);
        if ($category)
           // return response($category, 200);
            return $this->apiResponse(ResultType::Success, $category, 'Category fetched!', 200);
        else
            // return response(['message' => 'Category not found!'], 404);
            return $this->apiResponse(ResultType::Error, null, 'Category not found!', 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->name;
        $category->slug = \Illuminate\Support\Str::of($request->name)->slug('-');
        $category->save();
        /*
        return response([
            'data' => $category,
            'message' => 'Category successfully updated!'
        ], 200);
        */
        return $this->apiResponse(ResultType::Success, $category, 'Category successfully updated!',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return Response
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
        /*
        return response([
            'message' => 'Category successfully deleted!'
        ], 200);
        */
        return $this->apiResponse(ResultType::Success, null, 'Category successfully deleted!', 200);
    }

    public function custom1()
    {
        //return Category::pluck('name');
        return Category::pluck('name', 'id');
    }

    public function report1()
    {
        /*
        return DB::table('product_categories as pc')
               ->join('categories as c', 'c.id', '=', 'pc.category_id')
               ->join('product as p', 'p.id', '=', 'pc.product_id')
               ->selectRaw('c.name, COUNT(*) as total')
               ->groupBy('c.name')
               ->orderByRaw('COUNT(*) DESC')
               ->get();
        */

        return DB::table('product_categories as pc')
            ->join('categories as c', 'c.id', '=', 'pc.category_id')
            ->join('product as p', 'p.id', '=', 'pc.product_id')
            ->selectRaw('c.id as categoryId, c.name categoryName, COUNT(*) as total')
            ->groupByRaw('c.id, c.name')
            ->orderByRaw('COUNT(*) DESC')
            ->get();
    }
}
