<!-- 2021080315:40 完了画面 -->
@extends('layout.layout')
<!-- layoutフォルダ中のlayout.blade.php -->

@section('form')
<div class="main">
    <h3>会員登録完了</h3>
    <p>会員登録が完了しました!</p>
    <a class="back-btn" href="{{ url('/') }}">トップに戻る</a>
</div>
@endsection
