@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Contacts</h2>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('contacts.index') }}" class="input-group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email"
                        class="form-control">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Sort By: {{ request('sort') == 'name' ? 'Name' : 'Date' }}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item {{ request('sort') == 'name' ? 'active' : '' }}"
                                href="{{ route('contacts.index', ['sort' => 'name', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">Name</a>
                        </li>
                        <li><a class="dropdown-item {{ request('sort') == 'created_at' ? 'active' : '' }}"
                                href="{{ route('contacts.index', ['sort' => 'created_at', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}">Date</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $contact)
                        <tr>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->phone }}</td>
                            <td>{{ $contact->created_at->format('d-m-Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('contacts.show', $contact->id) }}"
                                        class="btn btn-info btn-sm me-2">View</a>
                                    <a href="{{ route('contacts.edit', $contact->id) }}"
                                        class="btn btn-warning btn-sm me-2">Edit</a>
                                    <form action="{{ route('contacts.destroy', $contact->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $contacts->links() }}
        </div>
    </div>
@endsection
