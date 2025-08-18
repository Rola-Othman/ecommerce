@extends('admin.layouts.master')
@section('content')
    <!-- Main Content -->
    <section class="section">
        <div class="section-header">
            <h1>Product Image Gallery</h1>
        </div>
 <div class="mb-3">
            <a href="{{route('admin.products.index')}}" class="btn btn-primary">Back</a>
         </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Product: {{ $product->name }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.products-image-gallery.store', ['product'=> $product->id]) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="image">Image <code>Multiple image supported</code></label>
                                    <input type="file" name="image[]" id="image" class="form-control" multiple>
                                    <input type="hidden" value="{{ $product->id }}" name="product_id">
                                </div>
                                 <button type="submit" class="btn btn-primary">Upload</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>All images</h4>

                        </div>
                        <div class="card-body">
                            {{ $dataTable->table() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $(document).ready(function() {
            $('body').on('click', '.change-status', function() {
                let isChecked = $(this).is(':checked');
                let id = $(this).data('id');

                $.ajax({
                    url: "{{ route('admin.product.change-status') }}",
                    method: 'PUT',
                    data: {
                        status: isChecked,
                        id: id
                    },
                    success: function(data) {
                        toastr.success(data.message)
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })

            })
        })
    </script>
@endpush
