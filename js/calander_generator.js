function Calander() {
	
	//creates the html for each calander day
	this.day = function(day) {
		
		var breakfastLabel = day + "Breakfast";
		var lunchLabel = day + "Lunch";
		var dinnerLabel = day + "Dinner";
		
		var dayString = "";
		dayString += "<div>";
		dayString += "<fieldset class=\"dayField\">";
		dayString += "<legend>" + day + "</legend>";
		
		dayString += "<label for=" + breakfastLabel + ">Breakfast</label>";
		dayString += "<input type=\"text\" name=" + breakfastLabel + " value=\"\" maxlength=\"50\">";
		
		dayString += "<label for=" + lunchLabel + ">Lunch</label>";
		dayString += "<input type=\"text\" name=" + lunchLabel + " value=\"\" maxlength=\"50\">";
		
		dayString += "<label for=" + dinnerLabel + ">Dinner</label>";
		dayString += "<input type=\"text\" name=" + dinnerLabel + " value=\"\" maxlength=\"50\">";
		
		dayString += "</fieldset>";
		dayString += "</div>"; 
		return dayString;
	}
	
	this.update = function(calanderDiv, checkBoxes) {
		calanderDiv.innerHTML = "";
		
		var dayList = [];
		for(var i = 0; i < checkBoxes.length; i++) {
			if(checkBoxes[i].checked == true){
			dayList.push(checkBoxes[i]);
			}
		}
		
		for(var i = 0; i<dayList.length; i++) {
			
			dayStuff = weekForm.day(dayList[i].value);
			calanderDiv.innerHTML += dayStuff;
		}
	}
}


var chooseDaysDiv = document.getElementById("chooseDaysDiv");
console.log(chooseDaysDiv); 
var fullList = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']; 

function chooseDays(fullList) {
	var chooseDaysString = "";
	chooseDaysString += "<div id=\"chooseDaysFormDiv\">";
	chooseDaysString += "<form id=\"chooseDaysForm\">";
	
	for(var i = 0; i < fullList.length; i++){
		var day = fullList[i];
		var dayLabel = day + "box";
		
		
		chooseDaysString += "<label for=" + dayLabel +">" + day + "</label>";
		chooseDaysString += "<input type=\"checkbox\" class=\"checkbox\" value=" + day + " name=" + dayLabel + ">";	
		
	}
	chooseDaysString += "<button type=\"button\" id=\"daysButton\" onclick=\"weekForm.update(calanderDiv, checkBoxes)\">Create Calander</button>";
	chooseDaysString += "</div>";
	chooseDaysString += "</form>";
	return chooseDaysString;
}