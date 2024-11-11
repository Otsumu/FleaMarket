@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/image_upload.css') }}">
@endsection

@section('content')
<div class="container">
    <h2>プロフィール画像をアップロード</h2>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('user.image_upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="image-group">
            <div class="image-container">
                <img src="{{ old('image') ? asset('storage/' . old('image')) : asset('storage/images/default.jpg') }}" alt="Profile Image" class="profile-image" id="profileImage">
            </div>
            <input type="file" name="image" accept="image/*" style="display: none;" id="imageInput">
            <button type="button" class="select-image-button" onclick="document.getElementById('imageInput').click();">画像を選択する</button>
        </div>
        <button type="submit">アップロード</button>
    </form>
</div>

<script>
    document.getElementById('imageInput').addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection