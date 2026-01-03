<h3>Pending Business Registrations</h3>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Business Name</th>
            <th>Owner Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($businesses as $b)
        <tr>
            <td>{{ $b->id }}</td>
            <td>{{ $b->business_name }}</td>
            <td>{{ $b->owner->name ?? '-' }}</td>
            <td>{{ $b->status }}</td>
            <td>
                <form method="POST" action="{{ route('superadmin.business.approve', $b->id) }}">
                    @csrf
                    <button type="submit">Approve</button>
                </form>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>