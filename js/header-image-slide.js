
// Speed of the automatic slideshow
var slideshowSpeed = 7500;

// Variable to store the images we need to set as background
// which also includes some text and url's.
var photos = [ {
    "title" : "Stairs",
    "image" : "DSC00114.JPG",
    "url" : "#",
    "firstline" : "Participants in the training program",
    "secondline" : ""
}, {
    "title" : "Office Appartments",
    "image" : "DSC00117.JPG",
    "url" : "#",
    "firstline" : "Participants in the training program",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "DSC00118.JPG",
    "url" : "#",
    "firstline" : "Participants in the training program",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "DSC00121.JPG",
    "url" : "#",
    "firstline" : "Some moments in the training program",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "DSC00123.JPG",
    "url" : "#",
    "firstline" : "Assistant Professor Suman Kanti Das delivering his lecture",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "DSC00124.JPG",
    "url" : "#",
    "firstline" : "Assistant Professor Suman Kanti Das delivering his lecture",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "DSC00127.JPG",
    "url" : "#",
    "firstline" : "Assistant Professor Suman Kanti Das delivering his lecture",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "IMG_0003.JPG",
    "url" : "#",
    "firstline" : "Welcome speech in Training by Prof. Dr. Md. Saleh Uddin",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "IMG_0006.JPG",
    "url" : "#",
    "firstline" : "Description of the image",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "IMG_9961.JPG",
    "url" : "#",
    "firstline" : "Some moments in the training program",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "IMG_9966.JPG",
    "url" : "#",
    "firstline" : "Guests in the training program",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "IMG_9972.JPG",
    "url" : "#",
    "firstline" : "Moments of the opening ceremony",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "IMG_9989.JPG",
    "url" : "#",
    "firstline" : "Speech given by participants",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "IMG_9992.JPG",
    "url" : "#",
    "firstline" : "Speech given by participants",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "IMG_9997.JPG",
    "url" : "#",
    "firstline" : "Welcome speech given by Prof. Dr. Kabir Hossain, Director, University Research Centre",
    "secondline" : ""
}, {
    "title" : "",
    "image" : "IMG_9998.JPG",
    "url" : "#",
    "firstline" : "Some moments in the training program",
    "secondline" : ""
}
];



$(document).ready(function() {
		
    // Backwards navigation
    $("#back").click(function() {
        stopAnimation();
        navigate("back");
    });
	
    // Forward navigation
    $("#next").click(function() {
        stopAnimation();
        navigate("next");
    });
	
    var interval;
    $("#control").toggle(function(){
        stopAnimation();
    }, function() {
        // Change the background image to "pause"
        $(this).css({
            "background-image" : "url(images/slideshow/btn_pause.png)"
        });
		
        // Show the next image
        navigate("next");
		
        // Start playing the animation
        interval = setInterval(function() {
            navigate("next");
        }, slideshowSpeed);
    });
	
	
    var activeContainer = 2;	
    var currentImg = 0;
    var animating = false;
    var navigate = function(direction) {
        // Check if no animation is running. If it is, prevent the action
        if(animating) {
            return;
        }
		
        // Check which current image we need to show
        if(direction == "next") {
            currentImg++;
            if(currentImg == photos.length + 1) {
                currentImg = 1;
            }
        } else {
            currentImg--;
            if(currentImg == 0) {
                currentImg = photos.length;
            }
        }
		
        // Check which container we need to use
        var currentContainer = 1;
		
        showImage(photos[currentImg - 1], currentContainer, activeContainer);
		
    };
	
    var currentZindex = -1;
    var showImage = function(photoObject, currentContainer, activeContainer) {
        animating = true;
		
        // Make sure the new container is always on the background
        currentZindex--;
                
        // Set the background image of the new active container
        $("#headerimg" + activeContainer).css({
            "background-image" : "url(images/slideshow/" + photoObject.image + ")",
            "display" : "block",
            "z-index" : currentZindex
        });
                
        // Hide the header text
        $("#headertxt").css({
            "display" : "none"
        });
		
        // Set the new header text
        $("#firstline").html(photoObject.firstline);
        $("#secondline")
        .attr("href", photoObject.url)
        .html(photoObject.secondline);
                        
				
        // Fade out the current container
        // and display the header text when animation is complete
        $("#headerimg" + currentContainer).fadeOut(function() {
            setTimeout(function() {
                $("#headertxt").css({
                    "display" : "block"
                });
                animating = false;
            }, 500);
        });
    };
	
    var stopAnimation = function() {
        // Change the background image to "play"
        $("#control").css({
            "background-image" : "url(images/slideshow/btn_play.png)"
        });
		
        // Clear the interval
        clearInterval(interval);
    };
	
    // We should statically set the first image
    navigate("next");
	
    // Start playing the animation
    interval = setInterval(function() {
        navigate("next");
    }, slideshowSpeed);
	
});