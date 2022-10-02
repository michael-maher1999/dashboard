<?php

namespace App\Http\Controllers\Apis;

use App\Models\Brand;
use App\Models\Product;
use App\Services\HasMedia;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{
    use ApiResponses;
    public function index(Request $request)
    {
        $products = Product::all(['id','name_'.App::currentLocale() . ' AS name',
        'details_'.App::currentLocale() . ' AS details',
        'code','quantity','status',
        'brand_id','subcategory_id','created_at','updated_at','price']);
        return $this->data(compact('products'),__('message.data.products'));
    }

    public function create()
    {
        $brands = Brand::select('id','name_en')->orderBy('name_en')->get();
        $subcategories = Subcategory::select('id','name_en')->orderBy('name_en')->get();
        // return response()->json(compact('brands','subcategories'));
        return $this->data(compact('brands','subcategories'));

    }

    public function store(StoreProductRequest $request)
    {
         $imageName = HasMedia::upload($request->file('image'),public_path('images\products'));
         $data = $request->except('image');
         $data['image'] = $imageName;
         Product::create($data);
         return $this->success("Product Created Successfully",201);
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::select('id','name_en')->orderBy('name_en')->get();
        $subcategories = Subcategory::select('id','name_en')->orderBy('name_en')->get();
        return $this->data(compact('product','brands','subcategories'));
    }

    public function update(UpdateProductRequest $request,$id)
   {
        $product = Product::findOrFail($id); // select
        $data = $request->except('image');
        // if request has image => upload new image , delete old image
        if($request->hasFile('image')){
            $imageName = HasMedia::upload($request->file('image'),public_path('images\products'));
            HasMedia::delete(public_path("images\products\\{$product->image}"));
            $data['image'] = $imageName;
        }

        $product->update($data);
        // update data into db
         return $this->success("Product Updated Successfully",201);

   }

   public function delete($id)
   {
        $product = Product::findOrFail($id); // select
        HasMedia::delete(public_path("images\products\\{$product->image}"));
        $product->delete();
        return $this->success("Product Deleted Successfully",201);
   }
}
