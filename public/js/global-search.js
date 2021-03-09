$(document).ready(function(){
    var inputObject = $('#search');
    var resultDropdown = inputObject.siblings("#searchResults");
    var spinner = inputObject.siblings("#spinner");

    spinner.hide();

    var doSearch = false;
    var madeSearch = true;
    var delay = 700;

    inputObject.on("input", function(event){
        doSearch = false;
        madeSearch = false;
    });

    function hideDropdown() {
        inputObject.css('border-radius', '15px');
        inputObject.css('border-color', '#1AA7A1');
        resultDropdown.empty();
        resultDropdown.hide();
        spinner.hide();
    }

    /*(function getGlobalResults() {
        if(doSearch) {
            //console.log('run search');
            var inputVal = inputObject.val();
            spinner.show();
            if (inputVal.length > 0)
                $.ajax({
                    type: "POST",
                    url: '/globalresults',
                    data: {input: inputVal}
                }).done(function (data) {
                    if(data) {
                        resultDropdown.show();
                        inputObject.css('border-color', ' #1AA7A1 #1AA7A1 transparent');
                        inputObject.css('border-radius', '15px 15px 0 0');
                        resultDropdown.html(data);
                        spinner.hide();
                    } else {
                        hideDropdown();
                    }
                });
            else {
                hideDropdown();
            }
            doSearch = false;
            madeSearch = true;
        }
        //console.log('typing');
        if(!madeSearch) doSearch = true;
        setTimeout(getGlobalResults, delay);
    } ());*/

    function convertToSlug(text) { // convert input to the formatted string
        return text
            .toLowerCase()
            .replace(/[^\w, ]+/g,'')
            .replace(/,+/g, '&')
            .replace(/ +/g,'+');
    }

    $(document).on("click", "#searchResults p", function(){
        window.location.href = '/search/s=' + convertToSlug($(this).text());
    });

    $('.magnifier').on("click", function(event){
        event.preventDefault();
        if(inputObject.val())
            window.location.href = '/search/s=' + convertToSlug(inputObject.val());
    });
    
    inputObject.on("keypress", function(event){
        if(event.which == 13)  // ignore non enter keys
            window.location.href = '/search/s=' + convertToSlug($(this).val());
    });
});
