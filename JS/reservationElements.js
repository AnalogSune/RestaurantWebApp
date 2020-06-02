function timesToDropdown(timesArray, defaultTime = 12){
	def = parseInt(defaultTime);
	if (timesArray.length){
        selectTime = "<select id='timeDropdown' name='timeDropdown'>";
		timesArray.forEach(timeSlot => {
			if (timeSlot.available_tables >= timeSlot.tables_needed){
			selectTime += "<option value='" + timeSlot.time + "'" + (timeSlot.time === def ? " selected":"") +">" + 
				timeSlot.time + ":00 - " + 
				(timeSlot.end_time) + ":00" +
				"</option>";
			}
		});
		selectTime += "</select>";
		return selectTime;
	} else {
		return null;
	}
}