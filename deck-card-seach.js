function updateSearch(){
    var url = 'https://api.scryfall.com/cards/search?q=' + htmlify($("#search").val());
    
	console.log(url);
    // second arg specifies the query parameters for the GET request
    var jqxhr = $.get(url);
    
    // Set the callback for if/when the AJAX request successfully returns
    jqxhr.done(function(data){
        // data will be the string response to the AJAX request
        //var obj = JSON.parse(data);
        //$("#results").text(obj.num_found + " results found.");
		var obj = data;
		var objlist = obj.data;
		//$('#search-results').empty();
		for(var i = 0; i < obj.total_cards; ++i){
			imgsrc = objlist[i].image_uris.normal;
			imgsrc = imgsrc.split("?")[0];
			$('#search-results').append('<img id="drag' + i + '" draggable="true" ondragstart="drag(event)" alt="cardImage" src="' + imgsrc + '" class="cardFormat"/>');
		}
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

function htmlify(inputString){
	var outputString = inputString;
	outputString.replace('%', '%25');
	outputString.replace(':', '%3A');
	outputString.replace('/', '%2F');
	outputString.replace('?', '%3F');
	outputString.replace('#', '%23');
	outputString.replace('[', '%5B');
	outputString.replace(']', '%5D');
	outputString.replace('@', '%40');
	outputString.replace('!', '%21');
	outputString.replace('$', '%24');
	outputString.replace('&', '%26');
	outputString.replace("'", '%27');
	outputString.replace('(', '%28');
	outputString.replace(')', '%29');
	outputString.replace('*', '%2A');
	outputString.replace('+', '%2B');
	outputString.replace(',', '%2C');
	outputString.replace(';', '%3B');
	outputString.replace('=', '%3D');
	outputString.replace(' ', '+');
	return outputString;
}


function makeDelay(ms) {
	var timer = 0;
	return (function(callback) {
		clearTimeout(timer);
		timer = setTimeout(callback, ms);
	});
};

$(document).ready(function(){
	console.log("Ready");
	var delay = makeDelay(100);
	$("#search").on("keyup change", function(){delay(updateSearch);});
	
  //$("#q").on("keyup change", updateSearch);
});
