<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResources;
use App\Http\Resources\ProductWithCategoriesResources;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends apiController
{


    /**
     * Display a listing of the resource.
     *
     * @return Response
     *
     * @OA\Get  (
     *     path="/products",
     *     tags={"product"},
     *     summary="List all products",
     *     operationId="index",
     *     @OA\Parameter (
     *         name="limit",
     *         in="query",
     *         description="How many items to return at one time?",
     *         required=false,
     *         @OA\Schema (type="integer", format="int32")
     *     ),
     *     @OA\Parameter (
     *         name="offset",
     *         in="query",
     *         description="Initial Value",
     *         required=false,
     *         @OA\Schema(type="integer", format="int32")
     *     ),
     *     @OA\Response (
     *         response=200,
     *         description="A paged array of products",
     *         @OA\JsonContent (type="array", @OA\Items (ref="#/components/schemas/Product"))
     *     ),
     *     @OA\Response (
     *         response=401,
     *         description="Unautorized!",
     *         @OA\JsonContent()
     *     ),
     *     @OA\Response (
     *         response="default",
     *         description="Unexpected Error!",
     *         @OA\JsonContent()
     *     ),
     *     security={
     *         {"bearer_token": {}}
     *     }
     * )
     */
    public function index(Request $request)
    {
//        return Product::all();
//        return response()->json(Product::all(), '200');
//        return response(Product::all(), 200);
//        return response(Product::paginate(10), 200);
//        $offset = $request->offset ? $request->offset : 0;
//        $limit = $request->limit ? $request->limit : 15;
//        return response(Product::offset($offset)->limit($limit)->get(), 200);
        $offset = $request->has('offset') ? $request->query('offset') : 0;
        $limit = $request->has('limit') ? $request->query('limit') : 10;

        $qb = Product::query()->with('categories');
        if ($request->has('q'))
            $qb->where('name', 'like', '%' . $request->query('q') . '%');
        if ($request->has('sortBy'))
            $qb->orderBy($request->query('sortBy'), $request->query('sort', 'DESC'));

        $data = $qb->offset($offset)->limit($limit)->get();
        $data = $data->makeHidden('slug');

        return response($data, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @OA\Post (
     *     path="/products",
     *     tags={"product"},
     *     summary="Create a new product",
     *     operationId="store",
     *     @OA\RequestBody (
     *         description="Set product name and price",
     *         required=true,
     *         @OA\JsonContent (ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response (
     *         response=201,
     *         description="Created product detail response",
     *         @OA\JsonContent (ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response (
     *         response=401,
     *         description="Unauthorized!",
     *         @OA\JsonContent ()
     *     ),
     *     @OA\Response (
     *         response="default",
     *         description="Unexcepted Error!",
     *         @OA\JsonContent ()
     *     ),
     *     security={
     *         {"bearer_token": {}}
     *     }
     * )
     */
    public function store(Request $request)
    {
//        $input = $request->all();
//        $product = Product::create($input);

        $product = new Product;
        $product->name = $request->name;
        $product->slug = \Illuminate\Support\Str::of($request->name)->slug('-');
        $product->price = $request->price;
        $product->save();

        return $this->apiResponse(ResultType::Success, $product, 'Product successfully created!', JsonResponse::HTTP_CREATED);

        /*
        return response([
            'data' => $product,
            'message' => 'Product successfully created!'
        ], 201);
        */
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     *
     * @OA\Get (
     *     path="/products/{productId}",
     *     tags={"product"},
     *     summary="Info for a specific product",
     *     operationId="show",
     *     @OA\Parameter (
     *         name="productId",
     *         in="path",
     *         description="The id column of the product to retrieve",
     *         required=true,
     *         @OA\Schema (type="integer", format="int64")
     *     ),
     *     @OA\Response (
     *         response=200,
     *         description="Product detail response",
     *         @OA\JsonContent (ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response (
     *         response=401,
     *         description="Unauthorized!",
     *         @OA\JsonContent ()
     *     ),
     *     @OA\Response (
     *         response="default",
     *         description="Unexcepted Error!",
     *         @OA\JsonContent ()
     *     ),
     *     security={
     *         {"bearer_token": {}}
     *     }
     * )
     */
//    public function show(Product $product)
    public function show($id)
    {
        /*
        $product = Product::find($id);
        if ($product)
            return response($product, 200);
        else
            return response(['message' => 'Product Not Found!'], 404);
        */
        try {
            $product = Product::findOrFail($id);
            return $this->apiResponse(ResultType::Success, $product, 'Product successfully found!', JsonResponse::HTTP_OK);
        } catch (NotFoundHttpException $exception) {
            return $this->apiResponse(ResultType::Error, null, 'Product Not Found!', JsonResponse::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return JsonResponse
     *
     * @OA\Put (
     *     path="/products/{productId}",
     *     tags={"product"},
     *     summary="Update the product",
     *     operationId="update",
     *     @OA\Parameter (
     *         name="productId",
     *         in="path",
     *         description="The column of the product to update",
     *         required=true,
     *         @OA\Schema (type="integer", format="int64")
     *     ),
     *     @OA\RequestBody (
     *         description="Set product name and price",
     *         required=true,
     *         @OA\JsonContent (ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response (
     *         response=200,
     *         description="Created product detail response",
     *         @OA\JsonContent (ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response (
     *         response=401,
     *         description="Unauthorized!",
     *         @OA\JsonContent ()
     *     ),
     *     @OA\Response (
     *         response="default",
     *         description="Unexcepted Error!",
     *         @OA\JsonContent ()
     *     ),
     *     security={
     *         {"bearer_token": {}}
     *     }
     * )
     */
    public function update(Request $request, Product $product)
    {
//        $input = $request->all();
//        $product->update($input);
        $product->name = $request->name;
        $product->slug = \Illuminate\Support\Str::slug($request->name);
        $product->price = $request->price;
        $product->save();

        try {
            return $this->apiResponse(ResultType::Success, $product, 'Product successfully updated!', JsonResponse::HTTP_OK);
        } catch (NotFoundHttpException $exception) {
            return $this->apiResponse(ResultType::Error, null, 'Product Not Found!', JsonResponse::HTTP_NOT_FOUND);
        }

        /*
        return response([
            'data' => $product,
            'message' => 'Product successfully updated!'
        ], 200);
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     *
     * @OA\Delete (
     *     path="/products/{productId}",
     *     tags={"product"},
     *     summary="Delete the product",
     *     operationId="destroy",
     *     @OA\Parameter (
     *         name="productId",
     *         in="path",
     *         description="The column of the product to delete",
     *         required=true,
     *         @OA\Schema (type="integer", format="int64")
     *     ),
     *     @OA\Response (
     *         response=200,
     *         description="Deleted product detail response",
     *         @OA\JsonContent (ref="#/components/schemas/ApiResponse")
     *     ),
     *     @OA\Response (
     *         response=401,
     *         description="Unauthorized!",
     *         @OA\JsonContent ()
     *     ),
     *     @OA\Response (
     *         response="default",
     *         description="Unexcepted Error!",
     *         @OA\JsonContent ()
     *     ),
     *     security={
     *         {"bearer_token": {}}
     *     }
     * )
     */
    public function destroy(Product $product)
    {
        $product->delete();
        try {
            return $this->apiResponse(ResultType::Success, $product, 'Product successfully deleted!', JsonResponse::HTTP_OK);
        } catch (NotFoundHttpException $exception) {
            return $this->apiResponse(ResultType::Error, null, 'Product Not Found!', JsonResponse::HTTP_NOT_FOUND);
        }
        /*
        return response([
            'message' => 'Product successfully deleted!'
        ], 200);
        */
    }

    public function custom1()
    {
//        return Product::select('id', 'name')->orderBy('created_at', 'DESC')->take(10)->get();
        return Product::selectRaw('id product_id, name as product_name')
            ->orderBy('created_at', 'desc')->take(10)->get();
    }

    public function custom2()
    {
        $product = Product::orderBy('created_at', 'desc')->take(10)->get();

        $mapped = $product->map(function ($product) {
            return [
                '_id' => $product['id'],
                'product_name' => $product['name'],
                'product_price' => $product['price'] * 1.05,
            ];
        });

        return $mapped->all();
    }

    public function custom3()
    {
        $products = Product::paginate(10);
        //return new ProductResources($products);
        return ProductResources::collection($products);
    }

    public function custom4($id)
    {
        $product = Product::find($id);
        ProductResources::withoutWrapping();
        return new ProductResources($product);
    }

    public function listsWithCategories()
    {
        $product = Product::with('categories')->paginate(10);
        return ProductWithCategoriesResources::collection($product);
    }
}
