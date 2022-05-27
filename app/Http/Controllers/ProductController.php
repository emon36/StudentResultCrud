<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use DB;

class ProductController extends Controller
{

    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
        $this->middleware('auth');
    }

    public function index()
    {
        $category = Category::all();
        $products = Product::all();

        return view('admin.product.index', ['category' => $category, 'products' => $products]);
    }

    public function fetchproduct()
    {
        $products = Product::orderBy('id','desc')->get();
        return response()->json([
            'products'=>$products,
        ]);
    }



    public function getSubCategory($category_id)
    {

        $subcategory = DB::table('subcategories')->where('category_id', $category_id)->get();
        return json_encode($subcategory);

    }

    public function store(Request $request)
    {
        $imageFileName = 'productImage.png';
        if ($request->hasFile('thumbnail')) {
            $productImageFile = $request->file('thumbnail');
            $imageFileName = 'product_' . time() . '.' . $productImageFile->getClientOriginalExtension();
            if (!file_exists('uploads/productFiles')) {
                mkdir('uploads/productFiles', 0777, true);
            }
            $productImageFile->move('uploads/productFiles', $imageFileName);
        }
        $data = $this->model->create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'thumbnail' => $imageFileName
        ]);

        return response()->json([
            'status' => 200,
        ]);

    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $product = Product::findOrFail($id);
        $imagePath = public_path('uploads/productFiles/'.$product->thumbnail);
        if (file_exists($imagePath))
        {
            unlink($imagePath);
        }
        $product->delete();
        return response()->json([
            'status'=>200,
            'message'=>'Product Deleted Successfully.'
        ]);
    }


}
