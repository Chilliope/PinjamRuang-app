
@extends('layouts.admin')

@section('title', 'Editing Major - Pinjam Ruang')

@section('content')
    <h1>Edit {{ $major->major }}</h1>

    <form action="/admin/majors/{{ $major->id }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="major">Major</label>

            <input
                type="text"
                id="major"
                name="major"
                value="{{ old('major', $major->major) }}"
                placeholder="Major"
            >

            @error('major')
                <p style="color: red;">{{ $message }}</p>
            @enderror
        </div>

        <br>

        <button type="submit">Edit</button>
    </form>
@endsection
