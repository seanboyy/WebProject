$(document).ready(function(){
	var jqxhr = $.get("get-user-info.php");
	console.log("Getting info...");
	jqxhr.done(function(data){
		console.log("Remember to load this in localhost");
		var _images = data.split(/<.?body>/);
		$("#cardList").append(_images[1]);
		$("#deckList").append(_images[1]);
	});
});
