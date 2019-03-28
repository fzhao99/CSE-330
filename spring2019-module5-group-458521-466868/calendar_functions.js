/* * * * * * * * * * * * * * * * * * * *\
 *               Module 4              *
 *      Calendar Helper Functions      *
 *                                     *
 *        by Shane Carr '15 (TA)       *
 *  Washington University in St. Louis *
 *    Department of Computer Science   *
 *               CSE 330S              *
 *                                     *
 *      Last Update: October 2017      *
\* * * * * * * * * * * * * * * * * * * */

/*  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */


(function () {

	/* Date.prototype.deltaDays(n)
	 *
	 * Returns a Date object n days in the future.
	 */
	Date.prototype.deltaDays = function (n) {
		// relies on the Date object to automatically wrap between months for us
		return new Date(this.getFullYear(), this.getMonth(), this.getDate() + n);
	};

	/* Date.prototype.getSunday()
	 *
	 * Returns the Sunday nearest in the past to this date (inclusive)
	 */
	Date.prototype.getSunday = function () {
		return this.deltaDays(-1 * this.getDay());
	};
}());

/** Week
 *
 * Represents a week.
 *
 * Functions (Methods):
 *	.nextWeek() returns a Week object sequentially in the future
 *	.prevWeek() returns a Week object sequentially in the past
 *	.contains(date) returns true if this week's sunday is the same
 *		as date's sunday; false otherwise
 *	.getDates() returns an Array containing 7 Date objects, each representing
 *		one of the seven days in this month
 */
function Week(initial_d) {

	this.sunday = initial_d.getSunday();


	this.nextWeek = function () {
		return new Week(this.sunday.deltaDays(7));
	};

	this.prevWeek = function () {
		return new Week(this.sunday.deltaDays(-7));
	};

	this.contains = function (d) {
		return (this.sunday.valueOf() === d.getSunday().valueOf());
	};

	this.getDates = function () {
		let dates = [];
		for(var i=0; i<7; i++){
			dates.push(this.sunday.deltaDays(i));
		}
		return dates;
	};
}

/** Month
 *
 * Represents a month.
 *
 * Properties:
 *	.year == the year associated with the month
 *	.month == the month number (January = 0)
 *
 * Functions (Methods):
 *	.nextMonth() returns a Month object sequentially in the future
 *	.prevMonth() returns a Month object sequentially in the past
 *	.getDateObject(d) returns a Date object representing the date
 *		d in the month
 *	.getWeeks() returns an Array containing all weeks spanned by the
 *		month; the weeks are represented as Week objects
 */
function Month(year, month) {

	this.year = year;
	this.month = month;

	this.nextMonth = function () {
		return new Month( year + Math.floor((month+1)/12), (month+1) % 12);
	};

	this.prevMonth = function () {
		return new Month( year + Math.floor((month-1)/12), (month+11) % 12);
	};

	this.getDateObject = function(d) {
		return new Date(this.year, this.month, d);
	};

	this.getWeeks = function () {
		var firstDay = this.getDateObject(1);
		var lastDay = this.nextMonth().getDateObject(0);

		var weeks = [];
		var currweek = new Week(firstDay);
		weeks.push(currweek);
		while(!currweek.contains(lastDay)){
			currweek = currweek.nextWeek();
			weeks.push(currweek);
		}

		return weeks;
	};
}
function fetchCalendarEvents(dateString){

    const date = {
        "curDate": dateString
    }
    fetch( "fetch_events.php", {
        method : 'POST',
        body: JSON.stringify(date),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
	.then(response=>response.json())
	// .then(res => console.log(res))

	.then(function(data){
		if(data.success){

		//append event object to each html cell
		if(data.events.length >0){
			let eventNumList = [];
			for (var e in data.events){
			// console.log(data.events);
			 let title = data.events[e].title;
			 let event_num = data.events[e].event_id;
			 let start_time = data.events[e].start.substr(11,8);
			 let end_time = data.events[e].end.substr(11,8);
			 let event_date = data.events[e].date;
			 let event_location = data.events[e].location;
			 let event_tag = data.events[e].tags;
			 if(event_tag == null || event_tag == ""){
				 event_tag = "no_tag";
			 }
			 document.getElementById(dateString).innerHTML += "<div class = '" + event_tag + "'><br><button class = 'event_button' id = 'event_num_" + event_num+ "'>"+start_time + " <b>" + title+"</b></button><br></div>";
			 document.getElementById(dateString).innerHTML += "<div class = 'event_form_popup' id = 'event_form_" + event_num + "'><form class = 'event_form_container'><h2>" + title + "</h2>Location: " + event_location + "<br>Start: " + start_time + "<br>End: " + end_time + "<br>Tag: " + event_tag + "</form></div>";

			 document.getElementById(dateString).innerHTML += "<div class = 'event_form_popup' id = 'edit_div_form_" + event_num + "'><form class = 'event_form_container' id = 'edit_form_" + event_num + "'>Title: <input type = 'text' id = 'edit_title_" + event_num + "'><br>Date: <input type = 'date' id = 'edit_date_" + event_num + "'><br>Start Time: <input type = 'time' id = 'edit_start_time_" + event_num + "'><br>End Time: <input type = 'time' id = 'edit_end_time_" + event_num + "'><br>Location: <input type = 'text' id = 'edit_location_" + event_num + "'></form></div>";

			 eventNumList.push(event_num);
			}


			for(var e in eventNumList){
			let event_num = eventNumList[e];
			let token = localStorage.getItem("token");
			$(document).ready(function(){
			$("#edit_div_form_" + event_num).dialog({
				autoOpen:false,

				buttons: [
					{
						text: "Save",
						click: function(){
							$.ajax({
								url: "editEvent.php",
								type: 'POST',
								dataType: 'json',
								data: {"event_num": event_num,"token":token, "event_name": $("#edit_title_"+event_num).val(), "event_date": $("#edit_date_"+event_num).val(), "start_time": $("#edit_start_time_"+event_num).val(), "end_time": $("#edit_end_time_"+event_num).val(), "event_location": $("#edit_location_"+event_num).val()}
							})
								$("#edit_div_form_" + event_num).dialog("close");
								updateCalendar();
							
							

						}
					}
				]
			})
			 $("#event_form_" + event_num).dialog({
				 autoOpen:false,

				 buttons: [
					 {
						text: "Delete",
						click: function(){
							$.ajax({
								url: 'deleteEvent.php',
								type: 'POST',
								dataType: 'json',
								data: {"event_num":event_num}
							})
							.done(function(data){
								console.log(data.success);
								$("#event_form_"+event_num).dialog("close");
								updateCalendar();
							})
						}
					 },
					 {
						text: "Edit",
						click: function(){
							$("#event_form_"+event_num).dialog("close");
							$("#edit_div_form_"+event_num).dialog("open");
						}
					 }
				 ]
			 });

			 $("#event_num_"+event_num).click(function(){
				 $("#event_form_" + event_num).dialog("open");

			 });
			})


			 //document.getElementById("event_num_" + event_num).addEventListener("click", function(){openEventForm(event_num);}, false);
			 //document.getElementById("close_event_" + event_num).addEventListener("click", function(){closeEventForm(event_num);}, false);
		}
			}



	}else{
		console.log(`${data.message}`);
	}


}
)
.catch(error => console.error('Error: ', error))

}// function openEventForm($event_num){
// 	document.getElementById("event_form_" + $event_num).style.display = "block";
// }

function openEventForm(event_num){
	// document.getElementById("event_form_" + event_num).style.display = "block";
}
function closeEventForm(event_num){
	document.getElementById("event_form_" + event_num).style.display = "none";
}


function openEventFormCopy(event_num){
	document.getElementById("event_form_" + event_num).style.display = "block";
}

function closeEventFormCopy(event_num){
	document.getElementById("event_form_" + event_num).style.display = "none";
}


const monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

function updateCalendar(){
	let curDateString = JSON.parse(sessionStorage.getItem("curDate"));
	let curDate = new Date(curDateString);

	let currentMonth = new Month(curDate.getFullYear(),curDate.getMonth());

	document.getElementById("month-label").textContent = monthNames[currentMonth.month] + " " + currentMonth.year;

	let weeks = currentMonth.getWeeks();
	for(let w in weeks){
		let days = weeks[w].getDates();
		// days contains normal JavaScript Date objects.
		let curWeekId = "week"+ w;
		// alert("Week starting on "+days[0]);
		document.getElementById(curWeekId).innerHTML = "";

		for(let d in days){
		let eventDateString = days[d].getFullYear() +"-" + (days[d].getMonth()+1) + "-"+ days[d].getDate();
		if(parseInt(w) <= 5){
			let events = fetchCalendarEvents(eventDateString);
			if(events != undefined){
				console.log(events);
			}


			if( days[d].getMonth()== currentMonth.month){
				document.getElementById(curWeekId).innerHTML+="<th class = 'inMonth' id= " +eventDateString+ ">" + days[d].getDate()+"</th>";
			}
			else{
				document.getElementById(curWeekId).innerHTML+="<th class = 'notInMonth'id= " +eventDateString+ ">" + days[d].getDate()+"</th>";
			}
			}

		else{
			document.getElementById(curWeekId).innerHTML+="<th class = 'notInMonth'id= " +eventDateString+ ">" + days[d].getDate()+"</th>";
		}
				// You can see console.log() output in your JavaScript debugging tool, like Firebug,
			// WebWit Inspector, or Dragonfly.
			// console.log(days[d].toISOString());
		}
	}



}

function nextMonth(){
	let currentDateString = sessionStorage.getItem("curDate");
	let curDate = new Date(JSON.parse(currentDateString));
	curDate.setMonth(curDate.getMonth() +1);
	sessionStorage.setItem("curDate",JSON.stringify(curDate));

	updateCalendar();

}


function prevMonth(){
	let currentDateString = sessionStorage.getItem("curDate");
	let curDate = new Date(JSON.parse(currentDateString));
	curDate.setMonth(curDate.getMonth() - 1);
	sessionStorage.setItem("curDate",JSON.stringify(curDate));

	updateCalendar();
}

function initialLoad(){

	let currentDate = new Date();
	sessionStorage.setItem("curDate", JSON.stringify(currentDate));

	updateCalendar();
}

function openAddEventForm() {

	// fetch("getUsers.php", {
	// 	method: "POST",
	// 	headers: {
	// 		"Accept": "application/json",
	// 		"Content-Type": "application/json"
	// 	}
	// })
	// .then(response => response.json())
	// // .then(res => console.log(res))
	// .then(function(data){
	// 	console.log(data);
	// 	for(let i=0;i<data.length;i++){
	// 		document.getElementById('toShareUsers').innerHTML += "<option>" + data[i] + "<option>";
	// 	}
	// })
	document.getElementById("myForm").style.display = "block";



  }

  function closeForm() {
	document.getElementById("myForm").style.display = "none";
  }

function add_event(){
	const event_name = document.getElementById('event_name').value;
	const event_date = document.getElementById('event_date').value;
	const start_time = document.getElementById('event_start_time').value;
	const end_time = document.getElementById('event_end_time').value;
	const event_location = document.getElementById('event_location').value;
	const users_To_Share = document.getElementById('usersToShare').value;
	let token = localStorage.getItem('token');


	let event_tag = "";
	let radios = document.getElementsByName('tag_type');
	for (var i = 0, length = radios.length; i < length; i++){
		if (radios[i].checked)
		{
			event_tag = radios[i].value;
			break;
		}
	}
	const data = {"event_name": event_name, "event_date": event_date, "start_time": start_time, "end_time": end_time, "usersToShare":users_To_Share, "event_location":event_location, "token" : token,"event_tag": event_tag};
	fetch("addEvent.php", {
		method: "POST",
		body: JSON.stringify(data),
		headers: {
			"Accept": "application/json",
			"Content-Type": "application/json"
		}
	})
	.then(response=>response.json())
	.then(function(data){
		if(data.success){
			updateCalendar();
			// console.log(`${data.message}`);
			closeForm();
		} else {
			// console.log(`${data.message}`);
		}
	})

}
function delete_event(event_num){
    //ADD EVENT NUM DIV IN MAIN.HTML IN ORDER FOR THIS TO EXTRACT THE EVENT_NUM
    const data = {"event_num": event_num};
    fetch("deleteEvent.php",{
        method:'POST',
        body: JSON.stringify(data),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }}
    )
    .then(response=>response.json())
    .then(function(data){
        if(data.success){
            console.log("Event successfully deleted");
        }
        else {
            console.log(`${data.message}`);
        }
    })
}
document.addEventListener("DOMContentLoaded",initialLoad,false);
document.addEventListener("DOMContentLoaded",function(){
		document.getElementById("next-month").addEventListener("click",nextMonth,false);
		document.getElementById("prev-month").addEventListener("click",prevMonth,false);
		document.getElementById("add-event").addEventListener("click", openAddEventForm,false);
		document.getElementById("button-close").addEventListener("click", closeForm,false);
		document.getElementById('add_event_submit').addEventListener("click", add_event, false);
		document.querySelector("input[name=school_tag]").addEventListener( 'change', function() {
			if(this.checked) {
				// Checkbox is checked..
				elements = document.getElementsByClassName("Extracurriculars");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "none";
				}
				elements = document.getElementsByClassName("Social");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "none";
				}
				elements = document.getElementsByClassName("School");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
				elements = document.getElementsByClassName("no_tag");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "none";
				}
			} else {
				// Checkbox is not checked..
				elements = document.getElementsByClassName("Extracurriculars");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
				elements = document.getElementsByClassName("Social");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
				elements = document.getElementsByClassName("no_tag");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
			}
		}, false);
		document.querySelector("input[name=extracurriculars_tag]").addEventListener( 'change', function() {
			if(this.checked) {
				// Checkbox is checked..
				elements = document.getElementsByClassName("School");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "none";
				}
				elements = document.getElementsByClassName("Social");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "none";
				}
				elements = document.getElementsByClassName("Extracurriculars");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
				elements = document.getElementsByClassName("no_tag");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "none";
				}
			} else {
				// Checkbox is not checked..
				elements = document.getElementsByClassName("School");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
				elements = document.getElementsByClassName("Social");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
				elements = document.getElementsByClassName("no_tag");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
			}
		}, false);
		document.querySelector("input[name=social_tag]").addEventListener( 'change', function() {
			if(this.checked) {
				// Checkbox is checked..
				elements = document.getElementsByClassName("School");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "none";
				}
				elements = document.getElementsByClassName("Extracurriculars");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "none";
				}
				elements = document.getElementsByClassName("Social");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
				elements = document.getElementsByClassName("no_tag");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "none";
				}
			} else {
				// Checkbox is not checked..
				elements = document.getElementsByClassName("School");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
				elements = document.getElementsByClassName("Extracurriculars");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
				elements = document.getElementsByClassName("no_tag");
				for (let i = 0; i < elements.length; i++){
					elements[i].style.display = "inline";
				}
			}
		}, false);
	}, false);
