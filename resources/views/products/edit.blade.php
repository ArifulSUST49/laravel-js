@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
        </div>
        <form action="{{ route('product.store') }}" method="post" autocomplete="off" spellcheck="false">
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
                                    <input type="text"value="{{$edit->title}}"
                                        name="product_name"
                                        id="product_name"
                                        required
                                        placeholder="Product Name"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="product_sku">Product SKU</label>
                                    <input type="text" name="product_sku" value="{{$edit->sku}}"
                                        id="product_sku"
                                        required
                                        placeholder="Product Name"
                                        class="form-control"></div>
                                <div class="form-group mb-0">
                                    <label for="product_description">Description</label>
                                    <textarea name="product_description"
                                            
                                            id="product_description"
                                            required
                                            rows="4"
                                            class="form-control">{{$edit->description}}</textarea>
                                </div>
                            </div>  
                        </div>
                        <!--                    Media-->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"><h6
                                    class="m-0 font-weight-bold text-primary">Media</h6></div>
                            <div class="card-body border">
                                <div id="file-upload" class="dropzone dz-clickable">
                                    <div class="dz-default dz-message">
                                        
                                    <input type="file" id="input-file-now" class="file-upload" />
                                      <script>
                                       $('.file-upload').file_upload();
                                      </script>
                                    
                                
                                
                                </div>
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
                            <label for="Option">Option</label><br>
                            <select name="option" id="option">
                                   
                             <option value="Color">Color</option>
                             <optgroup label="Color">
                              <option value="Red">Red</option>
                              <option value="Black">Black</option>
                              <option value="Green">Green</option>
                           </optgroup>
                                </select>
                            </div>
                            <div class="card-body pb-0" id="variant-sections">
                            <label for="Option">Option</label><br>
                            <select name="option" id="option">
                                   
                             <option value="size">Size</option>
                             <optgroup label="size">
                              <option value="Red">XL</option>
                              <option value="Black">L</option>
                              <option value="Green">M</option>
                           </optgroup>
                                </select>
                            </div>
                            <div class="card-footer bg-white border-top-0" id="add-btn">
                                <div class="row d-flex justify-content-center">
                                    <button class="btn btn-primary add-btn" onclick="addVariant(event);">
                                        Add another option
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow">
                            <div class="card-header text-uppercase">Preview</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr class="text-center">
                                            <th width="33%">Variant</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                        </tr>
                                        </thead>
                                        <tbody id="variant-previews">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-lg btn-primary">Save</button>
                <button type="button" class="btn btn-secondary btn-lg">Cancel</button>
            </section>
        </form>
    </div>
@endsection

@push('page_js')
    <script type="text/javascript" src="{{ asset('js/product.js') }}"></script>
@endpush
