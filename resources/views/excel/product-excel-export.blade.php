<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "//www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Products Excel Export</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <!-- General CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div class="container mt-4">
        <h1>Product List</h1>

        <!-- Filter Form -->
        <form action="{{ url('/mubsirproducts') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <label for="category_id" class="form-label">Select Category:</label>
                    <select name="category_id" id="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" 
                                @if(request('category_id') == $category->id) selected @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>

        <!-- Display Products in Table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>${{ $product->product_price }}</td>
                        <td>
                            @php
                                // Find the category name based on the category_id for each product
                                $category = $categories->firstWhere('id', $product->product_category_id);
                            @endphp
                            {{ $category ? $category->name : 'N/A' }}
                        </td>
                        <td>
                            @if($product->image_url != 'No Image')
                                <img src="{{ $product->image_url }}" alt="Product Image" style="width: 100px; height: auto;">
                            @else
                                No Image
                            @endif
                        </td> <!-- Display the image -->
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Button to Download Products as Excel -->
        <form action="{{ url('/mubsirproducts/export') }}" method="GET" class="mt-3">
            <input type="hidden" name="category_id" value="{{ request('category_id') }}">
            <button type="submit" class="btn btn-success">Download Excel</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
