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
                <h3>Povestile de succes de pe Gandeste Diferit</h3>
            </div>
            <div class="page-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <form action="{{url('addStory')}}" method="post">
                                @csrf
                                <div class="row p-4">
                                    <div class="col-md-6 ">
                                        <label for="name">Nume Poveste</label>
                                        <input type="text" class="form-control" name="title">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="video_id">Descriere scurta</label>
                                        <input type="text" class="form-control" name="excerpt">
                                    </div><br>
                                    <div class="col-md-6">
                                        <label for="length">Autor</label>
                                        <input type="text" class="form-control" name="author">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="length">Rol</label>
                                        <input type="text" class="form-control" name="role">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="length">Link imagine cover</label>
                                        <input type="text" class="form-control" name="cover">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="length">Descriere Lunga (cum se vede aici si vede si in pagina)</label>
                                        <textarea type="text" class="form-control" name="description" id="editor"></textarea>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <button class="btn btn-success btn-xs" value="submit">Adauga Poveste</button>
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
                                        <th>Titlu Poveste</th>
                                        <th>Autor</th>
                                        <th>Rol</th>
                                        <th>Descriere Scurta</th>
                                        <th>Actiuni</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data as $u)
                                        <tr>
                                            <td>{{$u->title}}</td>
                                            <td>{{$u->author}}</td>
                                            <td>{{$u->role}}</td>
                                            <td>{{$u->excerpt}}</td>
                                            <td>
                                                <a href="{{url('deleteStory') . "/" . $u->id}}" class="btn btn-danger btn-xs">Sterge</a>
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
