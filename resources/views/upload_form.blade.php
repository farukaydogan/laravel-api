@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload File</div>
                    <div id="output"></div>
                    <div class="card-body">
                        <form role="form" class="form" onsubmit="return false;">
                            <div class="form-group col-8">
                                <label for="upLoadFile">Select File: </label>
                                <input type="file" id="upLoadFile" class="form-control">
                            </div>
                            <button type="submit" id="upLoadBtn" class="btn btn-primary mt-3">Upload!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script>
        (function () {
            var output = document.getElementById('output');
            document.getElementById('upLoadBtn').onclick = function () {
                var data = new FormData();
                data.append('userId', '1');
                data.append('upLoadFile', document.getElementById('upLoadFile').files[0]);
                var config = {
                    header: {'Content-Type': 'multipart/form-data'},
                    onUploadProgress: function (progressEvent) {
                        var percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    }
                };
                axios.post('/api/upLoad', data, config)
                    .then(function (res) {
                        output.innerHTML = res.data.url;
                        console.log(res.data);
                    })
                    .catch(function (err) {
                        output.className = 'ms-3 mt-2 mb-0 text-danger';
                        output.innerHTML = err.message;
                    });
            };
        })();
    </script>
@endsection
