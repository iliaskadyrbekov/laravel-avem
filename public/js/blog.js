function goBack() {
    window.history.back();
}


function auto_grow(element) {
    element.style.height = "5px";
    element.style.height = (element.scrollHeight)+4+"px";
}

function handleFileSelectPhotoFirst(evt) {
    let file = evt.target.files;
    let f = file[0];
    if (!f.type.match('image.*')) {
        alert("Image only please....");
    }

    let reader = new FileReader();
    reader.onload = (function(theFile) {
        return function(e) {
            let span = document.createElement('span');
            span.innerHTML = ['<img class="carusel__photo" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
            document.getElementById('caruselUnit1').insertBefore(span, null);
        };
    })(f);
    reader.readAsDataURL(f);
}

function handleFileSelectPhotoSecond(evt) {
    let file = evt.target.files;
    let f = file[0];
    if (!f.type.match('image.*')) {
        alert("Image only please....");
    }

    let reader = new FileReader();
    reader.onload = (function(theFile) {
        return function(e) {
            let span = document.createElement('span');
            span.innerHTML = ['<img class="carusel__photo" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
            document.getElementById('caruselUnit2').insertBefore(span, null);
        };
    })(f);
    reader.readAsDataURL(f);
}

function handleFileSelectPhotoThird(evt) {
    let file = evt.target.files;
    let f = file[0];
    if (!f.type.match('image.*')) {
        alert("Image only please....");
    }

    let reader = new FileReader();
    reader.onload = (function(theFile) {
        return function(e) {
            let span = document.createElement('span');
            span.innerHTML = ['<img class="carusel__photo" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
            document.getElementById('caruselUnit3').insertBefore(span, null);
        };
    })(f);
    reader.readAsDataURL(f);
}

window.onload=function(){
    let elem = document.getElementById('caruselUnit1');
    if(elem){
        document.getElementById('caruselUnit1').addEventListener('change', handleFileSelectPhotoFirst, false);
        document.getElementById('caruselUnit2').addEventListener('change', handleFileSelectPhotoSecond, false);
        document.getElementById('caruselUnit3').addEventListener('change', handleFileSelectPhotoThird, false);
    }
}
