@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Employees') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <a href="{{ route('employee.create') }}" class="btn btn-outline-primary">Add New Employee</a>
                    <a href="{{ route('employee.create') }}" class="btn btn-outline-primary">Import from Excel</a>
                    <a href="{{ route('employee.create') }}" class="btn btn-outline-primary">Export PDF</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee )
                                <tr>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->company }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>
                                        <a href="{{ route('employee.edit', $employee->id) }}" class="btn btn-sm btn-outline-info">{{ __('Edit') }}</a>
                                        <form action="{{ route('employee.destroy', $employee->id) }}" method="post" class="d-inline-flex">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('{{ __('Are you sure?') }}')">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No employees</td>
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
