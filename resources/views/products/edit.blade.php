@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
        </div>

        @if(Session::has('msg'))
        <p class="alert alert-success">{{Session::get('msg')}}</p>
        @endif

        <form action="{{ route('product.update', $product->id) }}" method="POST" autocomplete="off" spellcheck="false">
            @csrf
            {{ method_field('PUT') }}
           <section>
                <div class="row">
                    <div class="col-md-6">
                        <!--                    Product-->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Product</h6>
                            </div>
                            <div class="card-body border">
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text"
                                        name="product_name"
                                        id="product_name"
                                        required
                                        placeholder="Product Name"
                                        class="form-control"
                                        value="{{ $product->title }}"
                                    >
                                </div>
                                <div class="form-group">
                                    <label for="product_sku">Product SKU</label>
                                    <input type="text" name="product_sku"
                                        id="product_sku"
                                        required
                                        placeholder="Product Name"
                                        class="form-control"
                                        value="{{ $product->sku }}"
                                        ></div>
                                <div class="form-group mb-0">
                                    <label for="product_description">Description</label>
                                    <textarea name="product_description"
                                            id="product_description"
                                            required
                                            rows="4"
                                            class="form-control">{{ $product->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <!--                    Media-->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"><h6
                                    class="m-0 font-weight-bold text-primary">Media</h6></div>
                            <div class="card-body border">
                                <div id="file-upload" class="dropzone dz-clickable">
                                <input type="file" id="image" name ="image"  class="file-upload" aria-describedby="helpId" />
                                      
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--                Variants-->
                    <div class="col-md-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3"><h6
                                    class="m-0 font-weight-bold text-primary">Variants</h6>
                            </div>
                            <div class="card-body pb-0" id="variant-sections">

                            @foreach($variants as $ky => $var)
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control" name="variant[{{ $ky }}][var]" required>
                                            <option value="{{ $var['id'] }}">{{ $var['title'] }}</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="variant[{{ $ky }}][items]" required>
                                            @foreach($var['pvariants'] as $key => $pv)

                                                @php($flag = false)

                                                @if($product->productVariantPrice[0]->productVariantOne->variant_id == $var['id'])
                                                    @if(strtoupper($product->productVariantPrice[0]->productVariantOne->variant) == strtoupper($pv))
                                                        <option value="{{ $key }}" selected>{{ $pv }}</option>
                                                        @php($flag = true)
                                                    @endif
                                                @endif

                                                @if($product->productVariantPrice[0]->productVariantTwo->variant_id == $var['id'])
                                                    @if(strtoupper($product->productVariantPrice[0]->productVariantTwo->variant) == strtoupper($pv))
                                                        <option value="{{ $key }}" selected>{{ $pv }}</option>
                                                        @php($flag = true)
                                                    @endif
                                                @endif

                                                @if($product->productVariantPrice[0]->productVariantThree->variant_id == $var['id'])
                                                    @if(strtoupper($product->productVariantPrice[0]->productVariantThree->variant) == strtoupper($pv))
                                                        <option value="{{ $key }}" selected>{{ $pv }}</option>
                                                        @php($flag = true)
                                                    @endif
                                                @endif

                                                @if($flag == false)
                                                    <option value="{{ $key }}">{{ $pv }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endforeach
                            </div>
                            <div class="card-footer bg-white border-top-0" id="add-btn">
                                <!-- <div class="row d-flex justify-content-center">
                                    <button class="btn btn-primary add-btn" onclick="addVariant(event);">
                                        Add another option
                                    </button>
                                </div> -->
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-header text-uppercase">Preview</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Price</th>
                                                <th>Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody id="variant-previews">
                                            <tr class="text-center">
                                                <th>
                                                    <input type="number" name="price"
                                                        required
                                                        placeholder="Product Price"
                                                        class="form-control" 
                                                        value="{{ $product->productVariantPrice[0]->price }}"/>
                                                </th>
                                                <th>
                                                    <input type="number" name="stock"
                                                            required
                                                            placeholder="Product Stock"
                                                            class="form-control" 
                                                            value="{{ $product->productVariantPrice[0]->stock }}"/>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="submit" class="btn btn-lg btn-primary" value="Submit">
                <button type="button" class="btn btn-secondary btn-lg">Cancel</button>
            </section>
        </form>
    </div>
@endsection

@push('page_js')
    <script type="text/javascript" src="{{ asset('js/product.js') }}"></script>
@endpush
