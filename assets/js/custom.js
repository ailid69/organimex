var transparentDemo = true;
var fixedTop = false;

$(document).scroll(function(e) {
    console.log('scrolling ...');
	oVal = ($(document).scrollTop() / 170);
    $(".ecoblur-container").css("opacity", oVal);
    console.log('custom.js ...');
});

