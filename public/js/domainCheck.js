var domains = ['gmail.com', 'aol.com'];
var secondLevelDomains = ['hotmail'];
var topLevelDomains = ["com", "net", "org"];


$(document).ready(function() {
    $('#email').on('blur', function (event) {
        console.log("event ", event);
        console.log("this ", $(this));
        $(this).mailcheck({
            domains: domains,                       // optional
            topLevelDomains: topLevelDomains,       // optional
            suggested: function (element, suggestion) {
                // callback code
                console.log("suggestion ", suggestion.full);
                $('#suggestion').html("Did you mean <b><i>" + suggestion.full + "</b></i>?");
            },
            empty: function (element) {
                // callback code
                $('#suggestion').html('');
            }
        });
    });
});