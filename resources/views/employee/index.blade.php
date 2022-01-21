@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">{{ __('Export Employees to PDF') }}</div>

                <div class="card-body">
                    <form action="{{ route('employee.pdf') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="company" class="col-md-4 col-form-label text-md-end">{{ __('Company Name') }}</label>

                            <div class="col-md-6">
                                <select id="company" class="form-control" name="company" ></select>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-outline-primary">
                                    {{ __('Export Employees') }}
                                </button>
                            </div>
                        </div>

                    </form>                    
                </div>
            </div>

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
                    <div class="d-flex justify-content-center">
                        {{ $employees->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#company').select2({
        placeholder: 'Select an company name',
        allowClear: true,
        ajax: {
            url: '/ajax/company',
            dataType: 'json',
            delay: 250, // wait 250 milliseconds before triggering the request
            processResults: function (data, params) {
                params.term = params.term || '';
                params.page = params.page || 1;
                return {
                    results:  $.map(data.results, function (item) {
                        // console.log(item)
                        return {
                            text: item.name,
                            id: item.name
                        }
                    }),
                    // pagination: data.pagination
                    pagination: {
                        more: (params.page * 10) < data.count_filtered
                    }
                };
            },
            cache: true
        }
    });
</script>
@endsection
