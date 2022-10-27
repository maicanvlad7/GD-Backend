@extends('layouts.dash')

@section('content')
    <div id="app">


        @include('sidebar')

        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>Editezi news cu id <span class="text-primary">{{$data['id']}}</span></h3>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-6 col-12 card rounded shadow p-3">
                        @if(Session::has('message') )
                            <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                                {{Session::get('message')}}
                            </div>
                        @endif
                        <form action="{{url('saveNewsEdit')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$data['id']}}" name="id">
                            <div class="form-group">
                                <label for="image">Imagine din bunny</label>
                                <input type="text" name="image" value="{{$data['image']}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="link">Link actiune (poate fi gol)</label>
                                <input type="text" name="link" value="{{$data['link']}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="score">Scor ( pentru ordonare)</label>
                                <input type="number" name="score" value="{{$data['score']}}" class="form-control">
                            </div>
                            <button class="btn btn-primary btn-xs mt-2">Salvează</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <img src="{{$data['image']}}" alt="" width="256px" >
                    </div>
                </div>
            </div>

{{--

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2021 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart"></i></span> by <a
                                href="http://ahmadsaugi.com">A. Saugi</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

@endsection
