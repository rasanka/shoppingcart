// create an instance of XMLHTTPRequest Object, varies with browser type, try for IE first then Mozilla
function getHTTPObject()
{
	var XmlHttpObj;
	// try creating for IE (note: we don't know the user's browser type here, just attempting IE first.)
	try
	{
		XmlHttpObj = new ActiveXObject("Msxml2.XMLHTTP");
	}
	catch(e)
	{
		try
		{
			XmlHttpObj = new ActiveXObject("Microsoft.XMLHTTP");
		} 
		catch(oc)
		{
			XmlHttpObj = null;
		}
	}
	// if unable to create using IE specific code then try creating for Mozilla (FireFox) 
	if(!XmlHttpObj && typeof XMLHttpRequest != "undefined") 
	{
		XmlHttpObj = new XMLHttpRequest();
	}
	
	return XmlHttpObj;
}