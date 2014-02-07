JPEGCam v1.0

Webcam library for capturing JPEG images and submitting to a server
Copyright (c) 2008 Joseph Huckaby <jhuckaby@goldcartridge.com>
Licensed under the GNU Lesser Public License
http://www.gnu.org/licenses/lgpl.html

OVERVIEW

JPEGCam is a simple, JavaScript and Flash library that allows you to enable
your users to submit Webcam snapshots to your server in JPEG format.  The
Flash movie is variable-sized, and has no visible user interface controls.
All commands sent to the movie are done so from JavaScript, so you can
implement your own look & feel on your site, create your own buttons, and
tell the Flash movie what to do from your own code.

REQUIREMENTS

	JavaScript-enabled browser
	Flash Player 9

EMBEDDING IN YOUR PAGE

(For a working example, see "test.html" in the htdocs folder.)

First, copy the following files to your web server:

	webcam.js
	webcam.swf
	shutter.mp3

Next, edit your HTML and load the JavaScript library:

	<script type="text/javascript" src="webcam.js"></script>

Configure a few settings (see API CALLS for complete list):

	<script language="JavaScript">
		webcam.set_api_url( 'test.php' );
		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound( true ); // play shutter click sound
	</script>

Load the movie into the page.  If you want to load the movie immediately, 
simply use document.write() as shown below.  If you are designing a DHTML
application, you can call webcam.get_html(...) at any time to dynamically
populate a DIV or other element after the page is finished loading.

	<script language="JavaScript">
		document.write( webcam.get_html(320, 240) );
	</script>

Add some controls for sending commands to the movie (see API CALLS):

	<br/><form>
		<input type=button value="Configure..." onClick="webcam.configure()">
		&nbsp;&nbsp;&nbsp;
		<input type=button value="Take Snapshot" onClick="webcam.snap()">
	</form>

Finally, add some code for handling the server response:

	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_callback_function' );
		function my_callback_function(response) {
			alert("Success! PHP returned: " + response);
		}
	</script>

That's it! See the following sections for a complete list of all the 
available API calls, and how to write the server-side code.

API CALLS

Here are all the available API calls for the JPEGCam JavaScript library.
Everything is under a top-level global 'webcam' namespace.

webcam.set_hook( HOOK_NAME, USER_FUNCTION );

	This allows you to set a user callback function that will be fired for
	various events in the JPEGCam system.  Here are all the events you 
	can hook:
	
	onLoad
		Fires when the Flash movie is loaded on the page.  This is useful
		for knowing when the movie is ready to receive scripting calls.
	
	onComplete
		Fires when the JPEG upload is complete.
		Your function will be passed the raw output from the API script 
		that received the file upload, as the first argument.
	
	onError
		Fires when an error occurs.  If this hook is not defined, the library
		will display a simple JavaScript alert dialog.  Your function will be
		passed the error text as the first argument.

webcam.set_api_url( URL );

	This allows you to set the URL to your server-side script that will 
	receive the JPEG uploads from the Flash movie. Beware of cross-domain 
	restrictions in Flash.

webcam.set_swf_url( URL );

	This allows you to set the URL to the location of the "webcam.swf" Flash
	movie on your server.  It is recommended to keep this file in the same
	directory as your HTML page, but if that is not possible, set the path
	using this function.  Beware of cross-domain restrictions in Flash.
	The default is the current directory that your HTML page lives in.

webcam.set_quality( QUALITY );

	This allows you to adjust the JPEG compression quality of the images 
	taken from the camera.  The range is 1 - 100, with 1 being the lowest
	quality (but smallest size files), to 100 being the highest quality
	(but largest files).  This does NOT control the resolution of the images,
	only the JPEG compression.  The default is 90.

webcam.set_shutter_sound( ENABLED );
	
	This allows you to enable or disable the "shutter" sound effect that 
	the Flash movie makes when a snapshot is taken.  Pass in a boolean
	true or false to the function.  It defaults to true.
	
	Feel free to customize the sound effect by replacing the "shutter.mp3"
	file with your own MP3 sound effect.

webcam.get_html( WIDTH, HEIGHT );

	This returns the necessary HTML code to embed the Flash movie into your
	page.  Pass in the desired pixel width & height, which not only controls
	the visual size of the movie, but also the JPEG image width & height.
	Standard sizes are 320x240 and 640x480.

webcam.snap();

	This instructs the Flash movie to take a snapshot and upload the JPEG
	to the server.  Make sure you set the URL to your API script using 
	webcam.set_api_url(), and have a callback function ready to receive
	the results from the server, using webcam.set_hook().

webcam.configure( PANEL );

	This launches one of Flash's configuration panels, used to setup camera
	devices, privacy settings, and more.  Pass in one of the following strings
	which sets the default panel "tab" in the settings dialog:
	"camera", "privacy", "default", "localStorage", "microphone", or 
	"settingsManager".  Example:
	
	webcam.configure( 'camera' );

SERVER-SIDE CODE

The Flash movie makes a HTTP POST to your server-side script, using the
Content-Type 'image/jpeg'.  This is a NON-STANDARD method which is unlike
submitting a form from a web page.  If you are using PHP, the JPEG data
will NOT be in the normal $_POST variable.  Instead, it will be in a
global variable named:

	$HTTP_RAW_POST_DATA

You can write this raw, binary JPEG data to a file handle using the PHP
function file_put_contents():

	$filename = "my_file.jpg";
	$result = file_put_contents( $filename, $HTTP_RAW_POST_DATA );

Any output from your script is passed back through the Flash movie to the 
JavaScript code, which in turn passes it to your onComplete callback function.

For example, if you want your script to pass back a URL to the JPEG image,
save the file where you want it, and construct a URL to the file.  Then simply
print the URL to the output like this:

(This assumes you are saving the files to the current working directory)

	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI'])
	 	. '/' . $filename;
	print "$url\n";

(See "test.php" for a working example.)

FAQ

Q. I cannot see the image from my camera!  What am I doing wrong?

A. You probably have to setup the camera device in the Flash Camera settings
   dialog first.  Often Flash doesn't auto-detect the right device.

		webcam.configure( 'camera' );

   It is always a good idea to provide a "Configure..." button on your
   page which calls this function, so users can easily get to it.


Q. What is this ugly permission dialog?  Can't I just make it remember me?

A. Yes, you certainly can!  In the Flash setup dialogs, click on the 2nd icon
   from the left (i.e. Privacy Settings), and you can click "Allow", then 
   check the "Remember" checkbox.

   You can send your users directly to the Privacy config panel by calling:
		webcam.configure( 'privacy' );

   A cool trick is to detect "new" users (via a cookie) and register an onLoad
   handler to send them directly to the Privacy settings.

		webcam.set_hook( 'onLoad', 'my_load_handler' );
		function my_load_handler() {
			if (is_new_user())
				webcam.configure( 'privacy' );
		}
		
		Of course, you have to write the is_new_user() function yourself.
		I no wanna be settin' no cookies on your domain.
