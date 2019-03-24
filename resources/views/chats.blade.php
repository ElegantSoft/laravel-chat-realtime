@extends('layouts.app')

@section('content')
    <div class="container" >
       <chats :user="{{Auth::user()}}" ></chats>
    </div>

@endsection
