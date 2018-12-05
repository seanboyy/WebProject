$(document).ready(function(){
	/*<!-- Standard Header to be used on every page. -->*/
	$("#header").append(
		"<div class=\"row\">" +
			"<div class=\"col-xs-3 noPad\">" +
				"<div class=\"headCol text-center\">" +
					"<button type=\"button\" class=\"headIcon\" id=\"tabs\">" +
						"<img alt=\"Tabs\" src=\"TabsIcon.png\" class=\"headIcon\"/>" +
					"</button>" +
				"</div>" +
			"</div>" +
			"<div class=\"col-xs-6 noPad\">" +
				"<div class=\"headCol text-center\">" +
					"<p class=\"title\">Magic Maker</p>" +
				"</div>" +
			"</div>" +
			"<div class=\"col-xs-3 noPad\">" +
				"<div class=\"headCol text-center\">"+
					"<button type=\"button\" class=\"headIcon\" id=\"options\">" +
						"<img alt=\"Options\" src=\"OptionsIcon.png\" class=\"headIcon\"/>"+
					"</button>" +
				"</div>" +
			"</div>" +
		"</div>" +
		"<div id=\"selectionArea\" class=\"selectionArea\">" +
		"</div>");
	$("#options").on("click", openOptions);
	$("#tabs").on("click", openTabs);
});

function openOptions(){
	if ($("#tabsArea").length) { //aka if the element with id "tabsArea" exists
		$("#selectionArea").empty();
	}
	
	if ($("#optionsArea").length) { //aka if the element with id "optionsArea" exists
		$("#selectionArea").empty();
	}
	else {
		$("#selectionArea").append(
		"<div id=\"optionsArea\"  class=\"text-center insideSelection\">" +
			"<a href=\"login.html\">Sign In</a>" +
			"<a href=\"profile.php\">Profile</a>" +
		"</div>"
		);
	}
}
    
function openTabs(){
	if ($("#optionsArea").length) { //aka if the element with id "optionsArea" exists
		$("#selectionArea").empty();
	}
	
	if ($("#tabsArea").length) { //aka if the element with id "tabsArea" exists
		$("#selectionArea").empty();
	}
	else {
		$("#selectionArea").append(
		"<div id=\"tabsArea\"  class=\"text-center insideSelection\">" +
			"<a href=\"index.html\">View Cards</a>" +
			"<a href=\"deck-main.php\">View Decks</a>" +
			"<a href=\"card-upload.html\">Card Upload </a>"	+
			"<a href=\"deck-upload.html\">Deck Upload </a>"	+
		"</div>"
		);
	}
}