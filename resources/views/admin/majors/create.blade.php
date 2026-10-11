@extends('layouts.admin')

@section('title', 'Create Major - Pinjam Ruang')

@section('content')
<h1>Create</h1>
@error('major')
    <p>{{ $message }}</p>
@enderror
<form action="/admin/majors" method="post">
    @csrf
    @method('post')
    <div>
        <label for="major">Major</label>
        <input type="text" id="major" name="major" placeholder="major">
    </div>
    <br>
    <button type="submit">Create</button>
</form>
@endsection
