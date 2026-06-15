@extends('layout.app')
@section('title')
    <title>List Students</title>
@endsection
@section('content')
    <div class="container">
        <a href="{{ route('students.create') }}" class="btn btn-info">create+</a>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            <a href="" data-bs-toggle="modal" data-bs-target="#student{{ $student->id }}">
                                <i class="fa-solid fa-eye text-success"></i>
                            </a>
                            |
                            <a href="{{ route('students.edit', $student->id) }}">
                                <i class="fa-solid fa-pen-to-square text-info"></i>
                            </a>
                            |
                            <a href="" data-bs-toggle="modal" data-bs-target="#deleteStudent{{ $student->id }}">
                                <i class="fa-solid fa-trash text-danger"></i>
                            </a>
                            @include('students.show')
                            @include('students.delete')

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
@endsection
