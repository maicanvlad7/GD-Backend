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
                <h3>Lectii pentru <strong class="text-danger">{{$course_name->name}}</strong></h3>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{url('addLessonToCourse')}}" method="post">
                                @csrf
                                <input type="hidden" value="{{$course_id}}" name="course_id">
                                <div class="row p-4">
                                    <div class="col-md-4 ">
                                        <label for="name">Nume Lectie</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="video_id">Id Video(Vimeo)</label>
                                        <input type="text" class="form-control" name="video_id">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="length">Durata Lectie</label>
                                        <input type="text" class="form-control" name="length" placeholder="2:30">
                                    </div>
                                    <div class="col-md-12 d-flex">
                                        <div class="form-check m-3">
                                            <div class="checkbox">
                                                <input type="checkbox" name="is_sample" id="checkbox1" class="form-check-input" >
                                                <label for="checkbox1">Trailer</label>
                                            </div>
                                        </div>
                                        <div class="form-check m-3">
                                            <div class="checkbox">
                                                <input type="checkbox" name="is_trailer" id="checkbox2" class="form-check-input" >
                                                <label for="checkbox2">Sample</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Lectie</button>
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
                                        <th>Nume</th>
                                        <th>ID Video (Vimeo)</th>
                                        <th>Durata</th>
                                        <th>Este Trailer</th>
                                        <th>Este Sample</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $u)
                                        <tr>
                                            <td>{{$u->name}}</td>
                                            <td>{{$u->video_id}}</td>
                                            <td>{{$u->length}}</td>
                                            <td>{{$u->is_trailer}}</td>
                                            <td>{{$u->is_sample}}</td>
                                            <td>
                                                <a href="{{url('deleteLesson') . "/" . $u->id}}" class="btn btn-danger btn-xs">Sterge</a>
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
