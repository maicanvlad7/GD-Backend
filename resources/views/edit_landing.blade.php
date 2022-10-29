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
                <h3>Editezi landing page-ul <span class="text-primary">{{$landing['title']}}</span></h3>

            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-6 col-12 card rounded shadow p-3">
                        @if(Session::has('message') )
                            <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                                {{Session::get('message')}}
                            </div>
                        @endif
                        <form action="{{url('saveLandingEdit')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{$landing['id']}}" name="id">
                            <div class="form-group">
                                <label for="title">Titlu</label>
                                <input type="text" class="form-control" name="title" placeholder="Titlu" value="{{$landing['title']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="description">Descriere</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="10">{{$landing['description']}}</textarea>
                            </div>
                            <div class="form-group mt-1">
                                <label for="vsl_id">ID VSL Vimeo</label>
                                <input type="text" id="vsl_id" class="form-control" name="vsl_id" placeholder="Subscription ID" value="{{$landing['vsl_id']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" class="form-control" name="slug" placeholder="Customer ID" value="{{$landing['slug']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="is_trial">Arata 7 Zile (1 = DA, 0 = NU)</label>
                                <input type="number" id="is_trial" class="form-control" name="is_trial" placeholder="Customer ID" value="{{$landing['is_trial']}}">
                            </div>
                            <button class="btn btn-primary btn-xs mt-2">Salvează</button>
                        </form>
                    </div>
                </div>
            </div>



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
