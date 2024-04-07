<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .content {
            margin-top: 20px;
            padding: 20px;
        }

        .card-img-top {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card-img-top:hover {
            transform: scale(1.05);
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap; /* Menambahkan baris baru jika tidak cukup lebar */
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            flex: 1;
            padding: 20px;
            max-width: 100%;
        }

        .content h3 {
            color: #333;
        }

        .content p {
            color: #666;
            max-width: 100%;
            overflow-wrap: break-word;
        }

        .btn {
            margin-top: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}" class="card-img-top">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h3 class="card-title">Product Details</h3>
                        <p><strong>Name:</strong> {{ $product->name }}</p>
                        <p><strong>Description:</strong></p>
                        <p>{{ $product->description }}</p>
                        <p><strong>Type:</strong> {{ $product->type }}</p>
                        <p><strong>Price:</strong> ${{ $product->price }}</p>

                         <!-- Tampilkan jumlah like -->
                         <p><strong>Likes:</strong> {{ $product->likes->count() }}</p>
                         <!-- Tampilkan form untuk memberi like -->
                         <form action="{{ route('products.like', $product->id) }}" method="POST">
                             @csrf
                             <button type="submit" class="btn btn-danger">Like</button>
                         </form> <br>
                        
                        <!-- Form untuk menambahkan komentar -->
                        <form action="{{ route('products.comment', $product->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="comment">Add a comment:</label>
                                <textarea class="form-control" id="comment" name="content" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <br>

                        <!-- Tampilkan daftar komentar -->
                        <h4>Comments</h4>
                        @foreach ($product->comments as $comment)
                            <div>
                                <p><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
                            </div>
                        @endforeach
                        <a href="javascript:window.history.back()" class="btn btn-secondary">Back</a>
                        <a href="{{ $product->link }}" class="btn btn-success">Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
