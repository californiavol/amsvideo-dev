/**
 * 
 */

var parameters =
    			{	id: "1"
    			,	src: "http://content.bitsontherun.com/videos/bkaovAYt-injeKYZS.mp4"				
    			,	autoPlay: "false"
    			,   width: "638"
    			,   height: "400"
				,	autoHideControlBar: "true"
				,	controlBarPosition: "over"
				,	plugin_simple : "http://osmf.realeyes.com/plugins/simple/SimpleOSMFPlugin.swf"
				,	simple_namespace : "http://osmf.realeyes.com/plugins/simple"
				,	simple_message : "The plugin has loaded."
    			};
			
    		    		
    		// Embed the player SWF:
    		
    		swfobject.embedSWF
				( "/video/assets/js/StrobeMediaPlayback.swf"
				, "player"
				, parameters["width"], parameters["height"]
				, "10.1.0"
				, {}
				, parameters
				, { allowFullScreen: "true" }
				, { name: "StrobeMediaPlayback" }
				);
			