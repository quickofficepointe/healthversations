@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h2>Processing Your Ebook Order</h2>
    <p>Please wait while we redirect you to the secure payment gateway...</p>
    
    <form id="iveriForm" action="{{ $iveriUrl }}" method="POST">
        @foreach($iveriData as $name => $value)
            <input type="hidden" name="{{ $name }}" value="{{ $value }}">
        @endforeach
    </form>

    <script>
        document.getElementById('iveriForm').submit();
    </script>
</div>
@endsection