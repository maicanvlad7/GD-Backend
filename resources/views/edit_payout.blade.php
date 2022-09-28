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
                <h3>Editezi payout-ul pentru teacher ID = {{$payout['id']}}</h3>
            </div>
            <div class="page-content">
                <div class="row">

                    <div class="col-md-6 col-12 card rounded shadow p-3">
                        @if(Session::has('message') )
                            <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i>
                                {{Session::get('message')}}
                            </div>
                        @endif
                        <form action="{{url('savePayoutEdit/' . $payout['id'])}}" method="post">
                            @csrf
                            <div class="row p-4">
                                <div class="col-md-6 mt-2">
                                    <label for="amount">Valoare payout</label>
                                    <input type="number" class="form-control" name="amount" value="{{$payout['amount']}}">
                                </div>
                                <div class="col-md-12 mt-2">
                                    <button class="btn btn-success btn-xs" value="submit">Salveaza Payout</button>
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
