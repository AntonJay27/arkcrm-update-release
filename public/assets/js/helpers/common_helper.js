const HELPER = (function(){

	let thisHelper = {};

	let baseUrl = $('#txt_baseUrl').val();

	let idleTime = 0;

	thisHelper.sampleHelper = function()
	{
		console.log('helper');
	}

	thisHelper.numberWithCommas = function(x)
	{
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
	}

	thisHelper.dateTimePast = function(createdDate,dateNow)
	{
		const date1 = new Date(createdDate);
		const date2 = new Date(dateNow);
		const diffMilliSeconds = Math.abs(date2 - date1);

		if(Math.abs(diffMilliSeconds / 1000) < 60)
		{
			return Math.abs(diffMilliSeconds / 1000).toFixed() + ' seconds';
		}
		else if(Math.abs(diffMilliSeconds / (1000 * 60)) < 60)
		{
			return Math.abs(diffMilliSeconds / (1000 * 60)).toFixed() + ' minutes';
		}
		else if(Math.abs(diffMilliSeconds / (1000 * 60 * 60)) < 24)
		{
			return Math.abs(diffMilliSeconds / (1000 * 60 * 60)).toFixed() + ' hours';
		}
		else if(Math.abs(diffMilliSeconds / (1000 * 60 * 60 * 24)) < 24) 
		{
			return Math.abs(diffMilliSeconds / (1000 * 60 * 60 * 24)).toFixed() + ' days';
		}
		else
		{
			return Math.abs(diffMilliSeconds / (1000 * 60 * 60 * 24)).toFixed() + ' days';
		}
	}

	thisHelper.checkEmptyFields = function(fieldValue, $altValue = "")
	{
		let arrEmpty = [null,"","NA","na","N/A","n/a"];

    return (arrEmpty.includes(fieldValue))? $altValue : fieldValue;
	}

	thisHelper.autoLogout = function()
	{
		// Increment the idle time counter every minute.
		var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

		// Zero the idle timer on mouse movement.
		$(document).mousemove(function (e) {
	    idleTime = 0;
		});
		$(document).keypress(function (e) {
	    idleTime = 0;
		});
	}

	function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 9) { // 20 minutes
      window.location.replace(`${baseUrl}/user-logout`);
    }
	}

	thisHelper.formatFileSize = function(bytes,decimalPoint) {
	   if(bytes == 0) return '0 Bytes';
	   var k = 1000,
	       dm = decimalPoint || 2,
	       sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
	       i = Math.floor(Math.log(bytes) / Math.log(k));
	   return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
	}
	
	return thisHelper;

})();