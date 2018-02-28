// JavaScript Document

var SERVER_URL = "http://localhost/phonerepairparts/admin/";
//var SERVER_URL = "http://www.edoctor.lk/admin/";

//var int=self.setInterval(function(){loadDashbordSummary()},10000);

function trim(str, chars) {
	return ltrim(rtrim(str, chars), chars);
}
 
function ltrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}
 
function rtrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}

function randomString() {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = 8;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}

function loadNewMenu(){
	var urlString = "common.logic.php?chksql=loadNewMenu";
	//alert(urlString);
	var http = getHTTPObject();
	http.open("POST", urlString , true);
	http.onreadystatechange = function() 
	{
		if (http.readyState == 4)
		{
			if (http.status == 200) 
			{
				//alert(http.responseText);
				document.getElementById("menu_div").innerHTML = http.responseText;
				createcssmenu();
			} 
			else
			{
				//alert("Error Occured : " + http.statusText);
			}
		}
	}
	http.send(null);
}

function showEbeesContact(){
	inlineMsg('powerdBy','<strong>Contact Us</strong><br />eBees Technology Solutions<br />Rasanka<br />0777265341',10);
}


String.prototype.ReplaceAll = function(stringToFind,stringToReplace){
    var temp = this;
    var index = temp.indexOf(stringToFind);
        while(index != -1){
            temp = temp.replace(stringToFind,stringToReplace);
            index = temp.indexOf(stringToFind);
        }
        return temp;
    }
	
String.prototype.startsWith = function(str) 
{return (this.match("^"+str)==str)}


String.prototype.endsWith = function(str) 
{return (this.match(str+"$")==str)}	