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
                <h3>Continut Gratuit GD</h3>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-3 shadow rounded">
                            <h4>Adauga curs gratuit</h4>
                            <form action="{{url('addFreeCourse')}}" method="post">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-12">
                                        <label for="course_id">Alege Curs</label>
                                        <select name="course_id" class="form-control">
                                            @foreach($all_courses as $c)
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Curs Gratuit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 rounded shadow mt-2">
                            <h5>Lista Cursuri Gratuite</h5>
                            @foreach($courses as $c)
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-evenly my-auto">
                                        <p class="mr-3">{{$c->name}}</p>
                                        <a href="{{url('deleteFreeCourse').'/'.$c->id}}" class="text-danger">Sterge Acces Gratuit</a>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{url('addFreeResource')}}" method="post">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-6">
                                        <label for="cover">Cover</label>
                                        <input type="text"  class="form-control" name="cover" placeholder="Link Bunny" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="vimeo_id">ID Vimeo</label>
                                        <input type="text" class="form-control"  name="vimeo_id" placeholder="7186950" required>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <label for="type">Tip</label>
                                        <select name="type" class="form-control">
                                            <option value="webinar">Webinar</option>
                                            <option value="interviu">Interviu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="title">Titlu</label>
                                        <input type="text" class="form-control"  name="title" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="description">Descriere</label>
                                        <input type="text" class="form-control"  name="description" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="subtitle">Subtitlu (optional)</label>
                                        <input type="text" class="form-control"  name="subtitle" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="guest">Invitat (optional)</label>
                                        <input type="text" class="form-control"  name="guest" >
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Free Content</button>
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
                                        <th>Titlu</th>
                                        <th>Subtitlu</th>
                                        <th>Descriere</th>
                                        <th>Tip</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($frees as $f)
                                        <tr>
                                            <td>{{$f->id}}</td>
                                            <td>{{$f->title}}</td>
                                            <td>{{$f->subtitle}}</td>
                                            <td>{{$f->description}}</td>
                                            <td>{{$f->type}}</td>
                                            <td>
                                                <a href="{{url('deleteFree') . "/" . $f->id}}" class="btn btn-outline-danger btn-xs">Sterge</a>
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



@endsection
