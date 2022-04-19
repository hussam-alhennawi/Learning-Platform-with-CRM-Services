
<video id="preview"></video>

<script src="{{asset('js2/instascan.min.js')}}"></script>

<script type="text/javascript">
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (content) {
        if(content.indexOf("check-in-by-scan") != -1)
        {
            var d = new Date();
            var time = parseInt(d.getTime()/1000);
            var url = content+'&checkTime='+time+'&student_id={{$user->id}}';
            window.location.replace(url);
        }
        else if(validURL(content))
        {
            var r = confirm("go to link :: "+content);
            if (r == true) 
            {
                window.location.replace(content);
            }
        }
        else
        {
            alert(content);
        }
    });
    Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) 
    {
        scanner.start(cameras[0]);
    } 
    else 
    {
        console.error('No cameras found.');
        alert('No cameras found.');
    }
    }).catch(function (e) {
        console.error(e);
        alert(e);
    });

    function validURL(str) 
    {
        var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|'+ // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
            '(\\#[-a-z\\d_]*)?$','i'); // fragment locator
        return !!pattern.test(str);
    }
</script>