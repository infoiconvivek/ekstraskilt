@extends('layouts.admin_layout')
@section('content')
@section('title', 'Add Product')


<!-- ========== App Menu ========== -->

<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->

            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">@if(isset($product)) Edit @else Add @endif Product</h4>

                        </div><!-- end card header -->

                        <div class="card-body">
                            @if (session('msg'))
                            <div class="alert alert-{{ session('msg_type') }}" role="alert">
                                {{ session('msg') }}
                            </div>
                            @endif

                            <form method="post" action="{{url('admin/product/save')}}" enctype="multipart/form-data">
                                @csrf

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs mb-3" role="tablist">

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#product" role="tab" aria-selected="false" tabindex="-1">
                                            Product
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#attribute" role="tab" aria-selected="false" tabindex="-1">
                                            Attribute
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#variants" role="tab" aria-selected="false" tabindex="-1">
                                            Variants
                                        </a>
                                    </li>


                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#gallery" role="tab" aria-selected="false" tabindex="-1">
                                            Gallery
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#design" role="tab" aria-selected="false" tabindex="-1">
                                            Design
                                        </a>
                                    </li>

                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#meta" role="tab" aria-selected="true">
                                            Meta
                                        </a>
                                    </li>

                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content  text-muted">

                                    <div class="tab-pane active" id="product" role="tabpanel">
                                        <div class="row gy-4">


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label>Select parent category*</label>
                                                    <select type="text" name="category_id" class="form-control">
                                                        <option value="">None</option>
                                                        @if($categories)
                                                        @foreach($categories as $category1)

                                                        @php $dash = '';
                                                        $selected_option = isset($product) ? $product->category_id : '';

                                                        @endphp
                                                        <option value="{{$category1->id}}" @if($category1->id==$selected_option){{'selected'}}@endif>{{$category1->title}}</option>
                                                        @if(count($category1->subcategory))
                                                        @include('admin.category.subCategoryList-option',['subcategories' => $category1->subcategory,'selected'=>$selected_option])
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                                @error('category_id')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="gallery_image" class="form-label">Product Image</label>
                                                    <input type="file" class="form-control" name="thumbnail">
                                                </div>
                                                @error('images')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="title" class="form-label">Title</label>
                                                    <input type="text" class="form-control" name="title" value="{{ isset($product)?$product->title:old('title') }}">
                                                </div>
                                                @error('title')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="price" class="form-label">Price</label>
                                                    <input type="text" class="form-control" name="price" value="{{ isset($product)?$product->price:old('price') }}">
                                                </div>
                                                @error('price')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="sell_price" class="form-label">Sell Price</label>
                                                    <input type="text" class="form-control" name="sell_price" value="{{ isset($product)?$product->sell_price:old('sell_price') }}">
                                                </div>
                                                @error('price')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="short_description" class="form-label">Short Description</label>
                                                    <textarea class="form-control summernote" name="short_description">{{ isset($product)?$product->description:old('short_description') }}</textarea>
                                                </div>
                                                @error('short_description')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="descriptions" class="form-label">Description</label>
                                                    <textarea class="form-control summernote" name="content">{{ isset($product)?$product->content:old('content') }}</textarea>
                                                </div>
                                                @error('description')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="sku" class="form-label">SKU</label>
                                                    <input type="text" class="form-control" name="sku" value="{{ isset($product)?$product->sku:old('sku') }}">
                                                </div>
                                                @error('title')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="name" class="form-label">Status</label>
                                                    <select name="status" class="form-control">
                                                        <option value="" @if(isset($product) && $product->status == '') {{"selected"}} @endif>--Select--</option>
                                                        <option value=" 1" @if(isset($product) && $product->status == 1) {{"selected"}} @endif selected="">Active</option>
                                                        <option value="0" @if(isset($product) && $product->status == 0) {{"selected"}} @endif>Inactive</option>
                                                    </select>

                                                    @error('status')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            <!--end col-->
                                        </div>
                                    </div>


                                    <div class="tab-pane show" id="attribute" role="tabpanel">
                                        <div class="row gy-4">


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="attribute_id" class="form-label">Attribute</label>
                                                    <select name="attribute_id" class="form-control" id="attribute-list">
                                                        <option value="">--Select--</option>
                                                        @foreach($attributes as $attr)
                                                        <option value="{{$attr->id}}"> {{$attr->name}} </option>
                                                        @endforeach
                                                    </select>

                                                    @error('attribute_id')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                            </div>


                                            <div class="col-xxl-6 col-md-6">
                                                <div>
                                                    <label for="name" class="form-label">Attribute Value</label>
                                                    <select name="attribute_value_id" class="form-control" id="attribute-value-list">
                                                        <option value="">--Select--</option>
                                                    </select>

                                                    @error('attribute_value_id')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror

                                                </div>
                                            </div>


                                            @if(isset($product))
                                            <div class="col-xxl-12 col-md-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Attribute</th>
                                                            <th scope="col">Value</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @foreach($product_attributes as $key=>$attributeData)
                                                        <tr>
                                                            <th scope="row">{{$key+1}}</th>
                                                            <td>{{$attributeData->attribute->name ?? ''}}</td>
                                                            <td>{{$attributeData->value->value ?? ''}}</td>
                                                            <td><a href="{{url('admin/product/delete-data/product_attribute?id='.$attributeData->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a></td>
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                            @endif

                                            <!-- end attributes-->

                                            <div id="attributes-section">
                                                @foreach ($attributes as $attribute)
                                                <div>
                                                    <h3>{{ $attribute->name }}</h3>
                                                    @foreach ($attribute->values as $value)
                                                    <label>
                                                        <input type="checkbox" name="attributes[{{ $attribute->id }}][]" value="{{ $value->id }}">
                                                        {{ $value->value }}
                                                    </label>
                                                    @endforeach
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" onclick="generateVariations()">Generate Variations</button>
                                            <div id="variations-section">
                                                @foreach ($variations as $variation)
                                                <div class="variation">
                                                    <input type="text" name="variations[][sku]" value="{{ $variation->sku }}" placeholder="SKU">
                                                    <input type="number" name="variations[][price]" value="{{ $variation->price }}" placeholder="Price">
                                                    <input type="hidden" name="variations[][attributes]" value="{{ $variation->attributes }}">
                                                </div>
                                                @endforeach
                                            </div>
                                            <!-- end attributes-->

                                        </div>
                                    </div>

                                    <div class="tab-pane show" id="variants" role="tabpanel">
                                        <div class="row gy-4">

                                            @if(isset($product))
                                            @foreach($variat_attributes as $key=>$attributeData)
                                            <div class="col-xxl-3 col-md-3">
                                                <label for="price" class="form-label">Attribute-{{$key+1}}</label>
                                                <select class="form-control">
                                                    <option value="">{{$attributeData->attribute->name ?? ''}} </option>
                                                    @php
                                                    $attr_values = App\Helpers\Helper::getPrdctAttrValus($attributeData->attribute_id);
                                                    @endphp
                                                    @foreach($attr_values as $attr_value)
                                                    <option value="{{$attr_value->value}}">{{$attr_value->value}}</option>
                                                    @endforeach
                                                </select>

                                            </div>

                                            @endforeach
                                            <div class="col-xxl-3 col-md-3">
                                                <div>
                                                    <label for="price" class="form-label">Price</label>
                                                    <input type="text" class="form-control" name="price">
                                                </div>
                                            </div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="tab-pane show" id="gallery" role="tabpanel">
                                        <div class="row gy-4">

                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="gallery_title" class="form-label">Title</label>
                                                    <input type="text" class="form-control" name="gallery_title">
                                                </div>
                                                @error('gallery_title')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="gallery_image" class="form-label">Image</label>
                                                    <input type="file" class="form-control" name="gallery_image">
                                                </div>
                                                @error('gallery_image')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="gallery_orderby" class="form-label">Order By</label>
                                                    <input type="number" class="form-control" name="gallery_orderby">
                                                </div>
                                                @error('gallery_orderby')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>


                                            @if(isset($product))
                                            <div class="col-xxl-12 col-md-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">#</th>
                                                            <th scope="col">Title</th>
                                                            <th scope="col">Image</th>
                                                            <th scope="col">Order</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @foreach($product_galleries as $key=>$gallery)
                                                        <tr>
                                                            <th scope="row">{{$key+1}}</th>
                                                            <td>{{$gallery->title}}</td>
                                                            <td><img src="{{URL::asset($gallery->image)}}" style="height:100px;width:100px;"></td>
                                                            <td>{{$gallery->order_by}}</td>
                                                            <td><a href="{{url('admin/product/delete-data/gallery?id='.$gallery->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a></td>
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                            @endif



                                        </div>
                                    </div>



                                    <div class="tab-pane show" id="design" role="tabpanel">
                                        <div class="row gy-4">


                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="sell_price" class="form-label">Design Id</label>
                                                    <input type="text" class="form-control" name="design_id" value="{{ isset($product)?$product->design_id:old('design_id') }}">
                                                </div>
                                                @error('price')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>

                                    <div class="tab-pane show" id="meta" role="tabpanel">
                                        <div class="row gy-4">


                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="meta_title" class="form-label">Meta Title</label>
                                                    <input type="text" class="form-control" name="meta_title" value="{{ isset($product)?$product->meta_title:old('meta_title') }}">
                                                </div>
                                                @error('meta_title')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="meta_keyword" class="form-label">Meta Keyword</label>
                                                    <textarea class="form-control" name="meta_keyword"> {{ isset($product)?$product->meta_keyword:old('meta_keyword') }}</textarea>
                                                </div>
                                                @error('meta_keyword')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                            <div class="col-xxl-12 col-md-12">
                                                <div>
                                                    <label for="meta_description" class="form-label">Meta Description</label>
                                                    <textarea class="form-control" name="meta_description"> {{ isset($product)?$product->meta_description:old('meta_description') }}</textarea>
                                                </div>
                                                @error('meta_description')
                                                <span class="text-danger">{{$message}}</span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>


                                </div>
                                <br>
                                <div class="row gy-4">
                                    <div class="col-xxl-4 col-md-4">
                                        <input type="hidden" name="old_image" value="{{ isset($product)?$product->image:old('old_image') }}">
                                        <input type="hidden" name="product_id" value="{{ isset($product)?$product->id:old('product_id') }}">
                                        <input type="submit" class="btn btn-info" value="submit">
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->




        </div> <!-- container-fluid -->
    </div><!-- End Page-content -->

    @include('includes.admin.footer')
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->

<script>
    /*$('#generateVariationsBtn').on('click', function() {
        $.ajax({
            url: 'http://165.232.130.162/ekstraskilt/admin/product/generate-variations',
            type: 'POST',
            data: {
                attributes: attributes,
                price: $('input[name="price"]').val(),
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                let variationsHtml = '';
                response.variations.forEach(variation => {
                    variationsHtml += `<div>${JSON.stringify(variation.attributes)} - ${variation.price}</div>`;
                });
                $('#variations').html(variationsHtml);
            }
        });
    });*/
</script>

<script>
    $('#attribute-list').on('change', function() {
        var attributeId = $(this).val();
        $('#attribute-value-list').empty(); // Clear subcategory list

        $.ajax({
            url: 'http://165.232.130.162/ekstraskilt/admin/get-attribute-values/' + attributeId,
            type: 'GET',
            success: function(response) {
                var attribute_values = response;
                attribute_values.forEach(function(attribute_value) {
                    $('#attribute-value-list').append('<option value="' + attribute_value.id + '">' + attribute_value.value + '</option>');
                });
            }
        });
    });
</script>

<script>
    CKEDITOR.replace('content');
</script>

<script>
    CKEDITOR.replace('short_description');
</script>

<script>
    const attributesData = @json($attributes);
    console.log(attributesData);
    function generateVariations() {
        console.log('first');
        const attributes = {};

        attributesData.forEach(attribute => {
            const values = [];
            document.querySelectorAll(`input[name="attributes[${attribute.id}][]"]:checked`).forEach(input => {
                values.push(input.value);
            });
            if (values.length) {
                attributes[attribute.id] = values;
            }
        });

        console.log(attributes);

        fetch("{{ route('products.generateVariations') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    attributes
                })
            })
            .then(response => response.json())
            .then(combinations => {
                const container = document.getElementById('variations-section');
                container.innerHTML = '';
                combinations.forEach(combination => {
                    const div = document.createElement('div');
                    div.className = 'variation';
                    div.innerHTML = `
                        <input type="text" name="variations[][sku]" placeholder="SKU">
                        <input type="number" name="variations[][price]" placeholder="Price">
                        <input type="hidden" name="variations[][attributes]" value='${JSON.stringify(combination)}'>
                    `;
                    container.appendChild(div);
                });
            });
    }
</script>


@stop