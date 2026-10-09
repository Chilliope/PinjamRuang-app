@extends('layouts.auth')

@section('title', 'Login - Pinjam Ruang')

@section('content')
<form action="" method="post">
    @csrf
    @method('post')
    <div>
        <label for="email">Email</label>
        <input type="email" placeholder="email@pinjamruang.republikode.com" id="email" name="email">
    </div>
    <br>
    <div>
        <label for="password">Password</label>
        <input type="password" placeholder="your password" id="password" name="password">
    </div>
    <br>
    <button type="submit">Login</button>
</form>
@endsection
