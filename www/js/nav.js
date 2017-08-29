$('#categorySubmenu').hide();

$('#projectsNav').hover( function(e) {
    $('#categorySubmenu').show();

    $('#categorySubmenu').mouseleave( function(e) {
    $('#categorySubmenu').hide();
});

});

$('#headerNav').mouseleave( function(e) {

//	if(document.getElementById('categorySubmenu').style.display != 'block') {
		$('#categorySubmenu').hide();
//	}
    

});

$('#homeNav').hover( function(e) {
    $('#categorySubmenu').hide();
});

$('#contactNav').hover( function(e) {
    $('#categorySubmenu').hide();
});
