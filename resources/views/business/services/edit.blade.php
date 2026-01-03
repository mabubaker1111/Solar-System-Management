<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Service</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4 p-4 mx-auto" style="max-width: 600px;">
        <h4 class="mb-4 text-primary fw-bold">Update Service</h4>

        <form action="{{ route('business.services.update', $service->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-semibold">Service Name</label>
                <input type="text" name="name" class="form-control form-control-lg rounded-3"
                       value="{{ $service->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Price (PKR)</label>
                <input type="number" name="price" class="form-control form-control-lg rounded-3"
                       value="{{ $service->price }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" rows="4"
                          class="form-control form-control-lg rounded-3">{{ $service->description }}</textarea>
            </div>

            <button class="btn btn-primary btn-lg px-4 rounded-3">Update Service</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
