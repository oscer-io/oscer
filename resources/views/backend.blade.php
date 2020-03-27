@extends('cms::layouts.backend')

@section('content')
    <transition :name="transitionName" mode="out-in">
        <router-view/>
    </transition>
@endsection
