<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/css/bootstrap.min.css"></link>
    <link rel="stylesheet" type="text/css" href="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/css/prettify.css"></link>
    <link rel="stylesheet" type="text/css" href="https://jhollingworth.github.io/bootstrap-wysihtml5//src/bootstrap-wysihtml5.css"></link>

    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form method="POST" action="/addTeacher">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nume</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="textarea" style="width: 730px; height: 200px"></textarea>
                </div>
                <button type="submit" value="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/js/wysihtml5-0.3.0.js"></script>
<script src="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/js/jquery-1.7.2.min.js"></script>
<script src="https://jhollingworth.github.io/bootstrap-wysihtml5//lib/js/prettify.js"></script>
<script src="https://jhollingworth.github.io/bootstrap-wysihtml5//src/bootstrap-wysihtml5.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.textarea').wysihtml5();
    });
</script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
</body>
</html>
