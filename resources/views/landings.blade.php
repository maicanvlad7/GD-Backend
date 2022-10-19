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
                <h3>Landing Pages Cursuri</h3>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{url('addLanding')}}" method="post">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-12">
                                        <label for="title">Titlu pagina</label>
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="description">Descriere pagina</label>
                                        <textarea name="description" id="description" class="form-control"></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="vsl_id">Id Video VSL Vimeo</label>
                                        <input type="text" name="vsl_id" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="course_id">Curs</label>
                                        <select name="course_id" id="course_id" class="form-control">
                                            @foreach($courses as $c)
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" class="form-control" placeholder="acesta-este-un-slug-fara-diacritice-si-spatii">
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Landing Page</button>
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
                                        <th>Titlu</th>
                                        <th>Descriere</th>
                                        <th>Curs</th>
                                        <th>VSL Id Vimeo</th>
                                        <th>Slug</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($landings as $u)
                                        <tr>
                                            <td>{{$u->title}}</td>
                                            <td>{{$u->description}}</td>
                                            <td>{{$u->course_name}}</td>
                                            <td>{{$u->vsl_id}}</td>
                                            <td>{{$u->slug}}</td>
                                            <td>
                                                <a href="{{url('editLanding') . "/" . $u->id}}" class="btn btn-info btn-xs">Edit</a>
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

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editor',
            skin: 'bootstrap',
            plugins: 'lists, link, image, media',
            toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
            menubar: false,
        });
    </script>

@endsection
