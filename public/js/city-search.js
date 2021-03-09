$(document).ready(function(){
    var inputObject = $('#location');
    var resultDropdown = inputObject.siblings("#locationResults");
    var spinner = inputObject.siblings("#spinner");

    spinner.hide();

    var doSearch = false;
    var madeSearch = true;
    var delay = 500;

    inputObject.on("input", function(){
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

    (function getLocationResults() {
        if(doSearch) {
            //console.log('run search');
            var inputVal = inputObject.val();
            spinner.show();
            if (inputVal.length > 0)
                $.ajax({
                    type: "POST",
                    url: '/locationresults/city',
                    data: {input: inputVal}
                }).done(function (data) {
                    if(data) {
                        resultDropdown.show();
                        inputObject.css('border-color', ' #1AA7A1 #1AA7A1 transparent');
                        inputObject.css('border-radius', '15px 15px 0 0');
                        spinner.hide();
                        resultDropdown.html(data);
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
        setTimeout(getLocationResults, delay);
    } ());

    $(document).on("click", "#locationResults p", function(){
        inputObject.val($(this).text());
        doSearch = true;
        madeSearch = false;
        hideDropdown();
    });
});
