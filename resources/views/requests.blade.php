<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Requests</title>
    <link rel="stylesheet" href="{{ asset('css') }}/app.css">
</head>
<body>
<div class="container">
    <div class="row">
        <!--<div class="col-6">
            <h3 class="display-5">Get Request</h3>
            <button type="button" class="btn btn-warning" id="getRequest">getRequest</button>
            <div id="getRequestData">
                <p></p>
            </div>
        </div>-->
        <div class="col-6">
            <h3 class="display-5">Update User</h3>
            <button type="button" class="btn btn-warning" id="updateUser">updateUser</button>
            <div id="getRequestData">
                <p></p>
            </div>
        </div>
        <div class="col-4">
            <h3 class="display-5">Register</h3>
            <form action="#" id="register">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label for="firstname">First Name: </label>
                <input type="text" id="firstname" class="form-control mb-3">
                <label for="lastname">Last Name: </label>
                <input type="text" id="lastname" class="form-control">
                <input type="submit" class="btn btn-success mt-3" value="Sign In">
            </form>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <p id="postRequestData"></p>
            </div>
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.0/axios.min.js"
        integrity="sha512-bPh3uwgU5qEMipS/VOmRqynnMXGGSRv+72H/N260MQeXZIK4PG48401Bsby9Nq5P5fz7hy5UGNmC/W1Z51h2GQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    /*
    // XMLHttpRequest
    // console.log(window)
    const request = new XMLHttpRequest()
    request.open('GET', 'http://localhost:8000/api/users')
    request.send()
    request.onload = () => {
        // console.log(request)
        // console.log(request.responseText)
        // console.log(request.response)
        if (request.status === 200) {
            // console.log(JSON.parse(request.response))
        } else {
            // console.log(request)
            // console.log('error ' + request.status)
        }
    }

    // Fetch Api
    // console.log(window)
    fetch('http://localhost:8000/api/users')
        .then(response => {
            return response.json()
        }).then(json => {
        // console.log(json)
    })

    // second approach
    async function getUsers() {
        let response = await fetch('http://localhost:8000/api/users');
        let data = await response.json();
        return data;
    }

    getUsers().then(response => {
        // console.log(response)
    })

    // Axios Library
    // console.log(window)
    axios.get('http://localhost:8000/api/users')
        .then(response => {
            // console.log(response.data);
        }, err => {
            // console.log(err)
        })

    // Jquery
    $(document).ready(function () {
        $.ajax({
            url: 'http://localhost:8000/api/users',
            type: 'get',
            success: function (result) {
                console.log(result);
            },
            error: function (err) {
                console.log(err);
            }
        });
    });
    */
    $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
       }
    });
    $(document).ready(function () {
        $('#getRequest').click(function () {
            // $.get('getRequest', function (data) {
            //     $('#getRequestData p').append(data)
            //     console.log(data);
            // });
            $.ajax({
                type: 'GET',
                url: 'getRequest',
                success: function (data) {
                    console.log(data);
                    $('#getRequestData').append(data);
                },
                error: function (err) {
                    console.log(err);
                    $('#getRequestData').append(err);
                }
            });
        });
        $('#register').submit(function () {
            var fname = $('#firstname').val();
            var lname = $('#lastname').val();

            //$.post('register', { firstname:fname, lastname:lname}, function (data) {
            //    console.log(data);
            //    $('#postRequestData').html(data);
            //})
            var dataString='firstname='+fname+'&lastname='+lname;
            $.ajax({
                type: 'POST',
                url: 'register',
                data: dataString,
                success: function (data) {
                    console.log(data);
                    $('#postRequestData').html(data);
                },
                error: function (err) {
                    console.log(err);
                    $('#postRequestData').html(err);
                }
            });
        });
        $('#updateUser').click(function () {
            var upDataString = 'name=Faruk Aydogan&email=info@farukAydogan.test&password=987654321'
            $.ajax({
                type: 'PUT',
                beforeSend: function (request) {
                  request.setRequestHeader('Authorization', 'Bearer nVmavd15vdidmhJBh9NQ1cJDGse6XfMWsY9koQF9TLNSpoFoJaU7oMxiPuVB')
                },
                url: 'http://localhost:8000/api/users/10',
                data: upDataString,
                success: function (answer) {
                    console.log(answer);
                    $('#getRequestData').append(answer);
                },
                error: function (err) {
                    console.log(err);
                    $('#getRequestData').append(err);
                }
            });
        });


    });
</script>
</body>
</html>



