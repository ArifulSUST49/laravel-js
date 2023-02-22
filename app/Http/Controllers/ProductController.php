<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Session;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $index = Product::with(
            'productVariant',
            'productVariantPrice',
            'productVariantPrice.productVariantOne',
            'productVariantPrice.productVariantTwo',
            'productVariantPrice.productVariantThree'
        );

        if (!empty($request->title))
        {
            $index = $index->where('title', 'like', '%'.$request->title.'%');
        }

        if (!empty($request->variant))
        {
            $pVariant = explode('=', $request->variant);
            $index = $index->whereHas('productVariant', function($item) use($pVariant){
                return $item->where('variant_id', intval($pVariant[0]))
                            ->orWhere('variant', $pVariant[1]);
            });
        }

        if (!empty($request->price_from))
        {
            $index = $index->whereRelation('productVariantPrice', 'price', '>', $request->price_from);
        }

        if (!empty($request->price_to))
        {
            $index = $index->whereRelation('productVariantPrice', 'price', '<', $request->price_to);
        }

        if (!empty($request->date))
        {
            $index = $index->whereBetween('created_at', [date('Y-m-d 00:00:01', strtotime($request->date)), date('Y-m-d 23:59:59', strtotime($request->date))]);
        }

        $index = $index->paginate(5);

        $getVerients = Variant::with('productVariant')->get();
        foreach($getVerients as $varient)
        {
            $varItems = $varient->productVariant->pluck('variant')->toArray();
            $varient->pvariants = array_unique(array_map('strtoupper', $varItems));
            unset($varient->productVariant);
        }
        $getVerients = $getVerients->toArray();

        return view('products.index', compact('index', 'getVerients'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::with('productVariant')->get();
        foreach($variants as $varient)
        {
            $varItems = $varient->productVariant->pluck('variant', 'id')->toArray();
            $varient->pvariants = array_unique(array_map('strtoupper', $varItems));
            unset($varient->productVariant);
        }
        $variants = $variants->toArray();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = [
            'title' => $request->product_name,
            'sku'   => $request->product_sku,
            'description' => $request->product_description,
        ];

        $product = Product::create($data);
        if ($product)
        {
            $variations = $request->variant;
            $varData = [
                'product_variant_one' => $variations[0]['items'],
                'product_variant_two' => $variations[1]['items'],
                'product_variant_three' => $variations[2]['items'],
                'price' => $request->price,
                'stock' => $request->stock,
                'product_id' => $product->id
            ];

            ProductVariantPrice::create($varData);
        }

        return redirect()->back()->with('msg', 'Data successful Added');

    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Product::findOrFail($id);
        return view('products.edit', compact('edit'));

        // $product_variant = Variant::findOrFail($id);
        // return view('products.variant.edit', compact('product_variant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
   
}
