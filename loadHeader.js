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
	if ($("#optionsArea").length || $("#tabsArea").length) { //aka if the element with id "optionsArea" exists
		$("#selectionArea").empty();
	}
	else {
		$("#selectionArea").append(
		"<div id=\"optionsArea\"  class=\"insideSelection\">" +
			"<p>Options Open</p>" +
		"</div>"
		);
	}
}
    
function openTabs(){
	if ($("#optionsArea").length || $("#tabsArea").length) { //aka if the element with id "optionsArea" exists
		$("#selectionArea").empty();
	}
	else {
		$("#selectionArea").append(
		"<div id=\"tabsArea\"  class=\"insideSelection\">" +
			"<p>Tabs Open</p>" +
		"</div>"
		);
	}
	//<a href=\"card-upload.html\">
}
//<button type="button" id="btn-add">Add Row</button>


	
	/*
    //var numCols = $("#dyn-list").find("th").length;
    
	var list = $("#dyn-list").find("li");
	
    var last = list.last();
    
	var newVal = parseInt(last.text()) + parseInt(last.prev().text());
	
    // The string given as the argument to $ is for
    //     a table row consisting of -- in each cell
    var newRow = ("<li>" + newVal + "</li>");  // If not using attr, remove the "$"
    
    //newRow.attr("id", "row-" + String(0)); // Used to add an id to a particular row - used to interact with a given row
    
    $("#dyn-list").append(newRow);*/