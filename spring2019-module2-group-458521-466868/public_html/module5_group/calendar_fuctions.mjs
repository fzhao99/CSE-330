import {Week, Month} from 'provided_API';

//MOVE THIS TO MAIN FILE AFTER YOU'RE DONE TESTING
var currentMonth = Month(2019,2);

function updateCalendar(){

    var weeks = currentMonth.getWeeks();
	
	for(var w in weeks){
		var days = weeks[w].getDates();
		// days contains normal JavaScript Date objects.
		
		alert("Week starting on "+days[0]);
		
		for(var d in days){
			// You can see console.log() output in your JavaScript debugging tool, like Firebug,
			// WebWit Inspector, or Dragonfly.
			console.log(days[d].toISOString());
		}
    }
    

}



document.addEventListener("DOMContentLoaded",updateCalendar,false);

