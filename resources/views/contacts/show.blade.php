@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Contact Details</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> {{ $contact->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $contact->email }}</li>
        <li class="list-group-item"><strong>Phone:</strong> {{ $contact->phone }}</li>
        <li class="list-group-item"><strong>Address:</strong> {{ $contact->address }}</li>
        <li class="list-group-item"><strong>Created At:</strong> {{ $contact->created_at->format('d-m-Y') }}</li>
        <li class="list-group-item"><strong>Updated At:</strong> {{ $contact->updated_at->format('d-m-Y') }}</li>
    </ul>
    <a href="{{ route('contacts.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
