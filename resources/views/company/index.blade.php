@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Companies') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <a href="{{ route('company.create') }}" class="btn btn-outline-primary">Add New Company</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Website</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($companies as $company )
                                <tr>
                                    <td><img src="{{ asset('storage/'.$company->logo) }}" alt="{{ $company->name }}" class="img-thumbnail" style="height: 50px"></td>
                                    <td>{{ $company->name }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->website }}</td>
                                    <td>
                                        <a href="{{ route('company.edit', $company->id) }}" class="btn btn-sm btn-outline-info">{{ __('Edit') }}</a>
                                        <form action="{{ route('company.destroy', $company->id) }}" method="post" class="d-inline-flex">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No companies</td>
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
