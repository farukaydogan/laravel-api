<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Instagram Requests</title>
    <link rel="stylesheet" href="{{ asset('css') }}/app.css">
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <p id="requestData"></p>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    $(document).ready(function () {
        $.ajax({
            async: true,
            type: 'GET',
            url: 'https://i.instagram.com/api/v1/friendships/25025320/following/?count=12&max_id=24',
            beforeSend: function (request) {
                request.setRequestHeader('Authority','i.instagram.com')
                request.setRequestHeader('Sec-Ch-Ua',' \" Not A;Brand\";v=\"99\", \"Chromium\";v=\"99\", \"Google Chrome\";v=\"99\"')
                request.setRequestHeader('X-Ig-Www-Claim','hmac.AR30cJ4D9Zi2XTZ7ifiElVwvdkA8aI_DVjy65wI-MLeSLlln')
                request.setRequestHeader('Sec-Ch-Ua-Mobile','?0')
                request.setRequestHeader('User-Agent','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36')
                request.setRequestHeader('Accept','*/*')
                request.setRequestHeader('X-Asbd-Id','198387')
                request.setRequestHeader('Sec-Ch-Ua-Platform',' \"macOS\"')
                request.setRequestHeader('X-Ig-App-Id','936619743392459')
                request.setRequestHeader('Origin','https://www.instagram.com')
                request.setRequestHeader('Sec-Fetch-Site','same-site')
                request.setRequestHeader('Sec-Fetch-Mode','cors')
                request.setRequestHeader('Sec-Fetch-Dest','empty')
                request.setRequestHeader('Referer','https://www.instagram.com/')
                request.setRequestHeader('Accept-Language','tr-TR,tr;q=0.9,en-US;q=0.8,en;q=0.7')
                request.setRequestHeader('Cookie','mid=YiIX-QAEAAE2K54QXqAnYknAOx-e; ig_did=AECFD4D5-8226-4C31-95DD-7BE39B8C174D; ig_nrcb=1; csrftoken=EfbTgbfQPAEP971e4vNQLzLx7TQbgqQo; ds_user_id=1388324522; sessionid=1388324522%3ACwNXFbqOO0WX0P%3A4; shbid=\"204705413883245220541677937550:01f70d633e4fea4d9219f856bea9b51d961fc82d577ce43f76e9e4c86465f03d2873de8b\"; shbts=\"164640155005413883245220541677937550:01f7d9f7cdb92a4e45f4690b93452b06667853f10fb1068e8c8687c4051231a238630a1c\"; fbm_124024574287414=base_domain=.instagram.com; fbsr_124024574287414=egX_i_ywzeyif6N3jQ9Yh8NTL23Nj9mbGoPdqeSZdvk.eyJ1c2VyX2lkIjoiMTAwMDA1Njc3OTU1Njk4IiwiY29kZSI6IkFRQzk4S1BFVGplTVZwVFJYOE1xN3dZOFI2THRzMzE5RVZ3MEVwMTNkTzJJT3VIenpGYnc0RTRHUXFfdzJySmdtTENzS3MweGk0dG5UUUIxOFBhSHRWT25STURaeFgydGhDS0NHVEdWem54V3FieS0zekxqWmMyRThBTGJCUDlXeS0xS3gxNDJlR3dtSDBRRlRsRUVJOUpwWklkT2d0aHJiQ2dxdXd4R1V4TW5IRk0ydnd6VTFyTThHZWgwdWpiY3RfY2wyUWsyWjZyaDBpUHZDbGF3WW5NcklXVldLbnVZWmJBSjItREs1cWgtWFl1NlFQZllTazh3OUdyaWRaYW02bldfSjh5M0xkaWhFam15eE5wQkZTbWJBZ3ViOG5oejBQdnZvcGhNQ3FZSUZpX1pwMW10bDFpMGtRMVljMlFMRWNkanFMd0dVQjVYX0kySEFhQUY3RDduIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQUtIcEd0R0RpTG1aQ2o2ZjBQdHlKaUlzeUhYYjdsdE5tRlpDU1VtZ1I5ZHlxM1dwRkRHSGhQaXVEVHRnV0pzTlM1dmFYaE9Ka09wUXl1eHJ6ZkFJRmNvZmJ3c2loNHNSM3JROWdWWkFoeGdaQ2tRRHJHQ3d0YWhDZGVjY0R6SGVNRm5QcW9SSEdicldGQzBSODhnd256dzhRYjk0WkNQZTl5RFZBTWJzdiIsImFsZ29yaXRobSI6IkhNQUMtU0hBMjU2IiwiaXNzdWVkX2F0IjoxNjQ2NDE1NDM4fQ; rur=\"ODN05413883245220541677951460:01f7400f6b6b3525e2423195f56a0b2887646ebb7826de075dfee16aab6474970403975b\"')
            },
            success: function (data) {
                console.log(data);
                $('#requestData').html(data);
            },
            error: function (err) {
                console.log(err);
                $('#requestData').html(err);
            }
        });
    });
</script>
</body>
</html>
