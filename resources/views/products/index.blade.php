@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Products</h1>
            <a class="btn btn-sm btn-primary" href="{{ route('product.create') }}">Add product</a>
        </div>

        @if(Session::has('msg'))
            <p class="alert alert-success">{{Session::get('msg')}}</p>
        @endif
        <div class="card">
                <div class="form-row justify-content-between">
                    <form action="{{ route('product.index') }}" method="GET" class="card-header row m-0">

                        <div class="col-md-2">
                            <input type="text" name="title" placeholder="Product Title" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <select name="variant" id="" class="form-control">
                                <option value="-Select A Varient-">-Select A Varient-</option>
                                @foreach($getVerients as $variant)
                                    <optgroup label="{{ $variant['title'] }}">
                                        @foreach($variant['pvariants'] as $pv)
                                            <option value="{{ $variant['id'].'='.$pv }}">{{ $pv }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Price Range</span>
                                </div>
                                <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control">
                                <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date" placeholder="Date" class="form-control">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary float-right">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>

                </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Variant</th>
                            <th width="150px">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach($index as $key => $data)
                                <tr>
                                    <td>{{  $data->id }}</td>
                                    <td>{{  $data->title }} <br> Created at : {{  date('d-M-Y', strtotime($data->created_at)) }}</td>
                                    <td style="max-width: 200px;">{{ substr($data->description, 0, 100) }}</td>
                                    <td>
                                        @foreach($data->productVariantPrice as $variant)
                                            <dl class="row mb-0" id="variant">
                                                <dt class="col-sm-3 pb-0">
                                                    {{$variant->productVariantOne->variant}} / {{$variant->productVariantTwo->variant}} / {{$variant->productVariantThree->variant}}
                                                </dt>
                                                <dd class="col-sm-9">
                                                    <dl class="row mb-0">
                                                        <dt class="col-sm-4 pb-0">Price : {{ number_format($variant->price, 2) }}</dt>
                                                        <dd class="col-sm-8 pb-0">InStock : {{ number_format($variant->stock, 2) }}</dd>
                                                    </dl>
                                                </dd>
                                            </dl>
                                        @endforeach
                                        <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('product.edit',$data->id ) }}" class="btn btn-success">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>

            </div>

            <div class="card-footer">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <p>Showing {{ ($index->currentPage() == 1)?1:($index->currentPage()-1)*5 }} to {{ $index->perPage()*$index->currentPage() }} out of {{ $index->total() }}</p>
                    </div>
                    <div class="col-md-6">
                        @if ($index->lastPage() > 1)
                            <nav class="float-end">
                                <ul class="pagination">
                                    <li class="page-item {{ ($index->currentPage() == 1) ? ' disabled' : '' }}">
                                        <a class="page-link" href="{{ $index->url(1) }}">
                                        <i class="bi bi-chevron-left"></i>
                                    </a></li>
                                    @for ($i = 1; $i <= $index->lastPage(); $i++)
                                        <li class="page-item {{ ($index->currentPage() == $i) ? ' active' : '' }}"><a class="page-link" href="{{ $index->url($i) }}">{{ $i }}</a></li>
                                    @endfor
                                    <li class="page-item {{ ($index->currentPage() == $index->lastPage()) ? ' disabled' : '' }}">
                                        <a class="page-link" href="{{ $index->url($index->currentPage()+1) }}">
                                        <i class="bi bi-chevron-right"></i>
                                    </a></li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
