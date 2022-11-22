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
                <h3>Inrebari Cursuri GD</h3>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{url('addQuestion')}}" method="post">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-6">
                                        <label for="user_id">Utilizator</label>
                                        <select name="user_id" class="form-control">
                                            @foreach($users as $u)
                                                <option value="{{$u->id}}">{{$u->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="course_id">Curs</label>
                                        <select name="course_id" class="form-control">
                                            @foreach($courses as $c)
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <label for="content">Intrebare</label>
                                        <textarea name="content" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Intrebare</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-12 col-12">
                        <div class="card">
                            @if(Session::has('message') )
                                <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                                    {{Session::get('message')}}
                                </div>
                            @endif
                            <div class="card-header">
                                Simple Datatable
                            </div>
                            <div class="card-body">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Curs</th>
                                        <th>Utilizator</th>
                                        <th>Intrebare</th>
                                        <th>Raspuns</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $u)
                                        <tr>
                                            <td>{{$u->id}}</td>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->cname}}</td>
                                            <td>{{$u->content}}</td>
                                            <td>{{$u->ac}}</td>
                                            <td>
                                                <a href="{{url('deleteQuestion') . "/" . $u->id}}" class="btn btn-outline-danger btn-xs">Sterge</a>
                                                <a class="btn btn-warning block sender" onclick="addAnswer( {{$u->id}},{{$u->idhost}} )" data-bs-toggle="modal" data-bs-target="#border-less">
                                                    Raspunde
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Raspunde la intrebare</h5>
                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{url('addAnswer')}}" method="POST">
                                @csrf
                                <input type="hidden" value="" name="aqid" id="aqid">
                                <input type="hidden" value="" name="ahid" id="ahid">
                                <textarea name="acontent" class="form-control" cols="30" placeholder="Raspuns intrebare"></textarea>
                                <button class="mt-2 btn btn-light-success">Adauga raspuns</button>
                            </form>
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

    <script src="{{asset('vendors/simple-datatables/simple-datatables.js')}}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>

    <script>
        //v = question id
        //b = user id
        //content from post
        function addAnswer(v,b) {
            let aqid = document.getElementById('aqid');
            let ahid = document.getElementById('ahid');

            aqid.value = v;
            ahid.value = b;
        }
    </script>



@endsection
