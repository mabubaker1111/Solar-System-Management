<form method="POST" action="{{ route('worker.register.submit') }}" enctype="multipart/form-data">
    @csrf
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" name="name" required value="{{ old('name') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" name="email" required value="{{ old('email') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" class="form-control" name="phone" required value="{{ old('phone') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" class="form-control" name="address" required value="{{ old('address') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" class="form-control" name="password_confirmation" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Select Business</label>
        <select class="form-select" name="business_id" required>
            <option value="">-- Select Business --</option>
            @foreach($businesses as $b)
                <option value="{{ $b->id }}">{{ $b->business_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Skill</label>
        <input type="text" class="form-control" name="skill" required value="{{ old('skill') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Experience (Years)</label>
        <input type="text" class="form-control" name="experience" required value="{{ old('experience') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Photo</label>
        <input type="file" class="form-control" name="photo">
    </div>
    <button type="submit" class="btn btn-primary w-100">Register Worker</button>
</form>
