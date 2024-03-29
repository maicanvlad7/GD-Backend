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
                <h3>Editezi rezumatul <span class="text-primary">{{$data['title']}}</span></h3>
            </div>
            <div class="page-content">
                <div class="row">

                    <div class="col-md-6 col-12 card rounded shadow p-3">
                        @if(Session::has('message') )
                            <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                                {{Session::get('message')}}
                            </div>
                        @endif
                        <form action="{{url('saveBookEdit/' . $data['id'])}}" method="post">
                            @csrf
                            <div class="row p-4">
                                <div class="col-md-12">
                                    <p style="color: red; font-size:14px; font-style: italic">Daca are audio se va completa cu 1 si link din bunny. Nu functioneaza fara sa fie audioAv = 1 indiferent de link</p>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="name">Audio disponibil (0 = nu are / 1 = are audio)</label>
                                    <input type="text" class="form-control" name="audio_av" value="{{$data['audio_av']}}">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="name">Link Bunny Audio</label>
                                    <input type="text" class="form-control" name="audio_path" value="{{$data['audio_path']}}">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="name">Nume Carte</label>
                                    <input type="text" class="form-control" name="title" value="{{$data['title']}}">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="length">Autor</label>
                                    <input type="text" class="form-control" name="author" value="{{$data['author']}}">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="length">Timp Citire (minute)</label>
                                    <input type="text" class="form-control" name="read_time" value="{{$data['read_time']}}">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="score">Scor (ajuta la ordonare in pagina de carti)</label>
                                    <input type="text" class="form-control" name="score" value="{{$data['score']}}">
                                </div>
                                <div class="col-md-12 mt-2">
                                    <label for="length">Link imagine cover</label>
                                    <input type="text" class="form-control" name="img" value="{{$data['img']}}">
                                </div>
                                <div class="col-md-12 mt-2">
                                    <label for="length">Continut Carte (cum se vede aici si vede si in pagina)</label>
                                    <textarea type="text" class="form-control" name="content" id="editor">{{$data['content']}}</textarea>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <button class="btn btn-success btn-xs" value="submit">Salveaza Rezumat Carte</button>
                                </div>
                            </div>
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
