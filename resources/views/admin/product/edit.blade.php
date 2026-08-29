@extends('layouts.app')
@push('before-css')
    <link rel="stylesheet" href="{{ asset('plugins/vendors/dropify/dist/css/dropify.min.css') }}">
    <style>
        .tag {
            display: inline-flex;
            align-items: center;
            background: #0d6efd;
            color: white;
            padding: 3px 8px;
            border-radius: 15px;
            margin: 2px;
            font-size: 14px;
        }

        .tag .remove-tag {
            margin-left: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .tag-error {
            background: #dc3545 !important;
            color: white;
        }

        #tags-input {
            border: none;
            outline: none;
            padding: 5px;
            min-width: 120px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 55px;
            height: 28px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 28px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #0d6efd;
        }

        input:checked+.slider:before {
            transform: translateX(27px);
        }
    </style>
@endpush
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Edit Product</h3>
            <div class="row breadcrumbs-top d-inline-block">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/product') }}">Product Management</a></li>
                        <li class="breadcrumb-item active">Edit Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <section id="basic-form-layouts">
            <form class="form" enctype="multipart/form-data" method="post"
                action="{{ route('admin.product.update', $product->id) }}">
                @csrf
                @method('PUT')
                <div class="row match-height">
                    <div class="col-md-7">
                        <!-- Product Info -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Product Info</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="text2">Text</label>
                                                    <input class="form-control" required name="text2" type="text"
                                                        id="text2" value="{{ old('text2', $product->text2) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name">Product Name</label>
                                                    <input class="form-control" required name="name" type="text"
                                                        id="name" value="{{ old('name', $product->name) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="summary-ckeditor">Description</label>
                                                    <textarea name="description" id="summary-ckeditor" cols="30" rows="10" class="form-control" required>{{ old('description', $product->description) }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="short_text">Also at</label>
                                                    <input class="form-control" required name="short_text" type="text"
                                                        id="short_text"
                                                        value="{{ old('short_text', $product->short_text) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Product Image</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Main Image</label>
                                        <input class="form-control dropify" name="image" type="file" id="image"
                                            data-default-file="{{ asset($primary_image) }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Gallery Images</label>
                                        <input class="form-control dropify" name="images[]" type="file" id="images"
                                            multiple>

                                        @if ($gallery_images)
                                            <div class="mt-2" id="gallery-images-container">
                                                @foreach ($gallery_images as $img)
                                                    <div class="gallery-image-wrapper" data-id="{{ $img->id }}"
                                                        style="display:inline-block; position:relative; margin:5px;">
                                                        <img src="{{ asset($img->image_path) }}" width="60"
                                                            class="rounded" />
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger remove-gallery-btn"
                                                            style="position:absolute; top:0; right:0; padding:2px 5px;">
                                                            &times;
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-actions text-right pb-0">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="la la-check-square-o"></i> Update Product
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div class="col-md-5">
                        <!-- Messages & Alerts -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Information</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="card-text">
                                        @if ($errors->any())
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li class="alert alert-danger">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if (Session::has('message'))
                                            <ul>
                                                <li class="alert alert-success">{{ Session::get('message') }}</li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pricing</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="paperback_price">Paperback Price</label>
                                                    <input class="form-control" name="paperback_price" type="text"
                                                        id="paperback_price"
                                                        value="{{ old('paperback_price', $product->paperback_price) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ebook_price">EBOOK Price</label>
                                                    <input class="form-control" name="ebook_price" type="text"
                                                        id="ebook_price"
                                                        value="{{ old('ebook_price', $product->ebook_price) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="rustica_price">Rústica Price</label>
                                                    <input class="form-control" name="rustica_price" type="text"
                                                        id="rustica_price"
                                                        value="{{ old('rustica_price', $product->rustica_price) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="taschenbuch_price">Taschenbuch Price</label>
                                                    <input class="form-control" name="taschenbuch_price" type="text"
                                                        id="taschenbuch_price"
                                                        value="{{ old('taschenbuch_price', $product->taschenbuch_price) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Organize -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Organize</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Select Category</label>
                                                    <select id="category" class="form-control select2"
                                                        name="category_id" required multiple
                                                        data-selected="{{ old('category_id', $product->category_id) }}">
                                                        <option value="">Select Category</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('plugins/vendors/dropify/dist/js/dropify.min.js') }}"></script>
    <script>
        $(function() {
            // Initialize Dropify
            $('.dropify').dropify();
        });

        $(document).ready(function() {

            function initSelect2(container = document) {
                $(container).find('.select2').select2({
                    width: '100%'
                });
            }

            // Repeater init
            $('.repeater-default').repeater({
                show: function() {
                    $(this).slideDown();
                    initSelect2(this); // re-init select2 on new row
                },
                hide: function(deleteElement) {
                    if (confirm('Are you sure?')) {
                        $(this).slideUp(deleteElement);
                    }
                }
            });

            initSelect2(); // first load

            // Attribute change event (works for repeater)
            $(document).on('change', '.attribute_id', function() {
                let attributeId = $(this).val();
                let row = $(this).closest('[data-repeater-item]');
                let valueSelect = row.find('.value');

                valueSelect.html('<option value="">Loading...</option>');

                $.ajax({
                    url: "{{ route('admin.product.get-attribute-values') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        attribute_id: attributeId
                    },
                    success: function(res) {
                        valueSelect.empty().append('<option value="">Select Value</option>');
                        if (res.status) {
                            $.each(res.data, function(i, val) {
                                valueSelect.append(
                                    `<option value="${val.id}">${val.value}</option>`
                                );
                            });

                            // For edit: select the current value if data attribute exists
                            let selectedValue = valueSelect.data('selected'); // set in Blade
                            if (selectedValue) {
                                valueSelect.val(selectedValue).trigger('change');
                            }
                        }
                    }
                });
            });

            // On page load: trigger AJAX for each existing row
            $('[data-repeater-item]').each(function() {
                let row = $(this);
                let attributeSelect = row.find('.attribute_id');
                let valueSelect = row.find('.value');

                let attributeId = attributeSelect.val();
                let selectedValue = row.data('value'); // set in Blade
                valueSelect.attr('data-selected', selectedValue);

                if (attributeId) {
                    attributeSelect.trigger('change');
                }
            });

            let categorySelected = $('#category').data('selected');
            let subcategorySelected = $('#subcategory').data('selected');

            // 🔹 CATEGORY SELECT2 (Infinite Scroll)
            $('#category').select2({
                placeholder: 'Select Category',
                width: '100%',
                ajax: {
                    url: "{{ route('admin.product.categories.select2') }}",
                    dataType: 'json',
                    delay: 250,
                    data: params => ({
                        search: params.term || '',
                        page: params.page || 1
                    }),
                    processResults: (data, params) => {
                        params.page = params.page || 1;
                        return {
                            results: data.results,
                            pagination: {
                                more: data.pagination.more
                            }
                        };
                    }
                }
            });

            // 🔹 SUBCATEGORY SELECT2 (Depends on Category)
            function initSubcategory(categoryId) {
                $('#subcategory').select2({
                    placeholder: 'Select Sub Category',
                    width: '100%',
                    ajax: {
                        url: "{{ route('admin.product.subcategories.select2') }}",
                        dataType: 'json',
                        delay: 250,
                        data: params => ({
                            category_id: categoryId,
                            search: params.term || '',
                            page: params.page || 1
                        }),
                        processResults: (data, params) => {
                            params.page = params.page || 1;
                            return {
                                results: data.results,
                                pagination: {
                                    more: data.pagination.more
                                }
                            };
                        }
                    }
                });
            }

            // 🔹 On Category Change
            $('#category').on('change', function() {
                let categoryId = $(this).val();
                $('#subcategory').val(null).trigger('change');

                if (categoryId) {
                    $('#subcat-container').show();
                    initSubcategory(categoryId);
                } else {
                    $('#subcat-container').hide();
                }
            });

            // 🔹 PRESELECT CATEGORY (Edit / old)
            if (categorySelected) {
                $.get("{{ route('admin.product.categories.select2') }}", {
                    id: categorySelected
                }, function(data) {
                    let option = new Option(data.text, data.id, true, true);
                    $('#category').append(option).trigger('change');
                });
            }

            // 🔹 PRESELECT SUBCATEGORY
            if (subcategorySelected && categorySelected) {
                $('#subcat-container').show();
                initSubcategory(categorySelected);

                $.get("{{ route('admin.product.subcategories.select2') }}", {
                    id: subcategorySelected
                }, function(data) {
                    let option = new Option(data.text, data.id, true, true);
                    $('#subcategory').append(option).trigger('change');
                });
            }

            // Tags input handling
            let tags = [];
            const tagInput = document.getElementById('tags-input');
            const tagBox = document.getElementById('tags-box');
            const hiddenField = document.getElementById('tags-hidden');

            // Load old tags from old() or existing product tags
            let existingTags = hiddenField.value ? hiddenField.value.split(',') : [];
            existingTags.forEach(t => addTag(t));

            // Add new tag on Enter
            tagInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    let value = tagInput.value.trim();
                    if (value === "") return;

                    if (tags.includes(value.toLowerCase())) {
                        showDuplicateError(value);
                        tagInput.value = "";
                        return;
                    }

                    addTag(value);
                    tagInput.value = "";
                }
            });

            function addTag(text) {
                text = text.trim();
                if (!text) return;

                tags.push(text.toLowerCase());

                const tag = document.createElement('span');
                tag.classList.add('tag');
                tag.innerHTML = `${text}<span class="remove-tag">&times;</span>`;

                tag.querySelector('.remove-tag').addEventListener('click', function() {
                    tag.remove();
                    tags = tags.filter(t => t !== text.toLowerCase());
                    hiddenField.value = tags.join(',');
                });

                tagBox.insertBefore(tag, tagInput);
                hiddenField.value = tags.join(',');
            }

            function showDuplicateError(text) {
                const errorTag = document.createElement('span');
                errorTag.classList.add('tag', 'tag-error');
                errorTag.innerHTML = text;
                tagBox.insertBefore(errorTag, tagInput);
                setTimeout(() => errorTag.remove(), 1200);
            }


            $(document).on('click', '.remove-gallery-btn', function() {
                if (!confirm('Are you sure you want to delete this image?')) return;

                let wrapper = $(this).closest('.gallery-image-wrapper');
                let imageId = wrapper.data('id');

                $.ajax({
                    url: "{{ route('admin.product.gallery.destroy') }}", // create this route
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: imageId
                    },
                    success: function(res) {
                        if (res.success) {
                            wrapper.remove();
                            $.toast({
                                heading: 'Success',
                                text: 'Image deleted successfully.',
                                position: 'top-right',
                                icon: 'success',
                                loaderBg: '#5ba035',
                                hideAfter: 3000
                            });
                        } else {
                            $.toast({
                                heading: 'Error',
                                text: 'Unable to delete image.',
                                position: 'top-right',
                                icon: 'error',
                                loaderBg: '#ff6849',
                                hideAfter: 3000
                            });
                        }
                    },
                    error: function() {
                        $.toast({
                            heading: 'Error',
                            text: 'Something went wrong.',
                            position: 'top-right',
                            icon: 'error',
                            loaderBg: '#ff6849',
                            hideAfter: 3000
                        });
                    }
                });
            });
        });
    </script>
@endpush
