@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Companies') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    <a href="{{ route('company.create') }}" class="btn btn-outline-primary">Add New Company</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($companies as $company )
                                <tr>
                                    <td><img src="{{ asset('storage/'.$company->logo) }}" alt="{{ $company->name }}" class="img-thumbnail" style="height: 50px"></td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>
                                        <a href="{{ route('company.edit', $company->id) }}" class="btn btn-sm btn-outline-info">{{ __('Edit') }}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No companies</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
