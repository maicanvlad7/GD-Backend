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
                <h3>Editezi teacher-ul <span class="text-primary">{{$host['name']}}</span></h3>
                <button type="button" class="btn btn-warning block" data-bs-toggle="modal" data-bs-target="#border-less">
                    Instructiuni importante
                </button>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-6 col-12 card rounded shadow p-3">
                        @if(Session::has('message') )
                            <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                                {{Session::get('message')}}
                            </div>
                        @endif
                        <p class="text-danger text-sm font-bold">Datele cu privire la utilizatori sunt foarte importante, verifica de doua ori inainte sa salvezi!</p>
                        <form action="{{url('teacher/' . $host['id'])}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nume</label>
                                <input type="text" id="name" class="form-control" name="name" placeholder="Nume" value="{{$host['name']}}">
                            </div>
                            <div class="form-group mt-1">
                                <label for="title">Titlu</label>
                                <textarea name="title" id="title" class="form-control" cols="30" rows="5">{{$host['title']}}</textarea>
                            </div>
                            <div class="form-group mt-1">
                                <label for="description">Descriere SCURTA</label>
                                <textarea name="description" id="description" class="form-control" cols="30" rows="5">{{$host['description']}}</textarea>
                            </div>
                            <div class="form-group mt-1">
                                <label for="image">Link imagine Bunny</label>
                                <input type="text" id="image" class="form-control" name="image" placeholder="Customer ID" value="{{$host['image']}}">
                            </div>
                            <button class="btn btn-primary btn-xs mt-2">Salvează</button>
                        </form>
                    </div>
                </div>

{{--                modal--}}
                <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Important pentru editarea unui teacher</h5>
                                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ol>
                                    <li>La titlu dupa fiecare linie de titlu vom adauga "< br >" - fara spatii</li>
                                    <li>Nu sarim peste partea de poza</li>
                                </ol>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="button" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Ok</span>
                                </button>
                            </div>
                        </div>
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
