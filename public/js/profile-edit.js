$(document).ready(function(){
    var inputObject = $('#status');
    let targetElement = $('#inputCounter');
    inputObject.on("input", function(){
        targetElement.html(inputObject.val().length + '/100');
    });
});

function loadImage(evt) {
    var tgt = evt.target || window.event.srcElement,
        files = tgt.files;
    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            if ( evt.target.id === 'poster-img') {
                console.log(files[0]);
                console.log(fr.result);
                document.getElementById('bg_img').style.background = 'url(' + fr.result + ')';
                document.getElementById('bg_img').style.backgroundPosition = 'center';
                document.getElementById('bg_img').style.backgroundSize = 'cover';
            } else {
                document.getElementById('prof_img').style.background = 'url(' + fr.result + ')';
                document.getElementById('prof_img').style.backgroundPosition = 'center';
                document.getElementById('prof_img').style.backgroundSize = 'cover';
            }
        }
        fr.readAsDataURL(files[0]);
    }
}
//background: linear-gradient(0deg, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url('data:image/jpg;base64,{{$user->background_image}}') 100% 100% no-repeat;background-position: center;
window.onload=function(){
    let elem = document.getElementById('poster-img');
    if(elem){
        document.getElementById('poster-img').addEventListener('change', loadImage, false);
        document.getElementById('poster-avatar').addEventListener('change', loadImage, false);
    }
}
