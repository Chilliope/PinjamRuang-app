@extends('layouts.admin')

@section('title', 'Create Building - Pinjam Ruang')

@section('content')
<h1>Create Building</h1>

<form action="/admin/buildings" method="post">
    @csrf
    @method('post')

    <div>
        <label for="building_name">Building Name</label>
        <input type="text" id="building_name" name="building_name" placeholder="building name...">
    </div>
    <div>
        <label for="major_id">Major</label>
        <select name="major_id" id="major_id">
            <option value="">Universal</option>
            @foreach ($majors as $major)
            <option value="{{ $major->id }}">{{ $major->major }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <button type="submit">create</button>
    </div>
</form>
@endsection
