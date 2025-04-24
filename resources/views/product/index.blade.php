@extends('layouts.main')
@section('title', 'Data Categories')

@section('content')

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $title ?? '' }}</h5>
                    <div class="mt-4 mb-3">
                        <div align="right" class="mb-3">
                            <a class="btn btn-primary" href="{{route('product.create')}}">Add Product</a>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Photo</th>
                                <th>Description</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no=1; @endphp
                            @foreach ($datas as $index => $data)
                                <tr>
                                    <td>{{ $index += 1 }}</td>
                                    <td>{{ $data->category->category_name }}</td>
                                    <td>{{ $data->product_name }}</td>
                                    <td>{{ $data->product_price }}</td>
                                    <td><img width="100" src="{{ asset('storage/' . $data->product_photo) }}"
                                        alt=""></td>
                                    <td>{{ $data->is_active ? 'publish' : 'Draft' }}</td>
                                    <td>
                                        <a href="{{ route('product.edit', $data->id) }}" class="btn btn-sm btn-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form class="d-inline" action="{{ route('product.destroy', $data->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

