function updateSearch(){
    var url = 'https://api.scryfall.com/cards/random';
    
    // second arg specifies the query parameters for the GET request
    var jqxhr = $.get(url, {title: $("#search").val()} );
    
    // Set the callback for if/when the AJAX request successfully returns
    jqxhr.done(function(data){
        // data will be the string response to the AJAX request
        //var obj = JSON.parse(data);
        //$("#results").text(obj.num_found + " results found.");
		var obj = data;
		imgsrc = obj.image_uris.normal;
		imgsrc = imgsrc.split("?")[0];
		$('#cards').append('<img alt="cardImage" src="' + imgsrc + '" class="cardFormat"/>');
		sleep(100);
    });
    
    // Set the callback for if/when the AJAX request fails
    jqxhr.fail(function(result){
        // result is the failed call (so we can access status, e.g.)
        $("#cards").append('<p>Call Failed</p>');
        console.log("Error: " + result.status);
    });
    
    // Set a callback to execute regardless of success or failure result
    jqxhr.always(function(){
        console.log("Done with AJAX request");
    });
};


function makeDelay(ms) {
	var timer = 0;
	return (function(callback) {
		clearTimeout(timer);
		timer = setTimeout(callback, ms);
	});
};

$(document).ready(function(){
	console.log("Ready");
	var delay = makeDelay(250);
	$("#q").on("keyup change", function(){delay(updateSearch);});
	
  //$("#q").on("keyup change", updateSearch);
});
