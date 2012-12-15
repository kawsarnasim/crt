
// Speed of the automatic slideshow
var slideshowSpeed = 6000;

// Variable to store the images we need to set as background
// which also includes some text and url's.
var photos = [ {
		"title" : "Stairs",
		"image" : "vacation.jpg",
		"url" : "http://www.sxc.hu/photo/1271909",
		"firstline" : "Going on",
		"secondline" : "vacation?"
	}, {
		"title" : "Office Appartments",
		"image" : "work.jpg",
		"url" : "http://www.sxc.hu/photo/1265695",
		"firstline" : "Or still busy at",
		"secondline" : "work?"
	}, {
		"title" : "Mountainbiking",
		"image" : "biking.jpg",
		"url" : "http://www.sxc.hu/photo/1221065",
		"firstline" : "Get out and be",
		"secondline" : "active"
	}, {
		"title" : "Mountains Landscape",
		"image" : "nature.jpg",
		"url" : "http://www.sxc.hu/photo/1271915",
		"firstline" : "Take a fresh breath of",
		"secondline" : "nature"
	}, {
		"title" : "Italian pizza",
		"image" : "food.jpg",
		"url" : "http://www.sxc.hu/photo/1042413",
		"firstline" : "Enjoy some delicious",
		"secondline" : "food"
	}, {
		"title" : "Naval Academy",
		"image" : "Naval_Academy.jpg",
		"url" : "http://www.sxc.hu/photo/1042413",
		"firstline" : "Enjoy The Beuty of",
		"secondline" : "Naval Academy"
	}, {
		"title" : "Chrysanthemum",
		"image" : "Chrysanthemum.jpg",
		"url" : "http://www.sxc.hu/photo/1042413",
		"firstline" : "Enjoy The Beuty of",
		"secondline" : "Naval Academy"
	}, {
		"title" : "Desert",
		"image" : "Desert.jpg",
		"url" : "http://www.sxc.hu/photo/1042413",
		"firstline" : "Enjoy The Beuty of",
		"secondline" : "Naval Academy"
	}, {
		"title" : "Hydrangeas",
		"image" : "Hydrangeas.jpg",
		"url" : "http://www.sxc.hu/photo/1042413",
		"firstline" : "Enjoy The Beuty of",
		"secondline" : "Naval Academy"
	}, {
		"title" : "Jellyfish",
		"image" : "Jellyfish.jpg",
		"url" : "http://www.sxc.hu/photo/1042413",
		"firstline" : "Enjoy The Beuty of",
		"secondline" : "Naval Academy"
	}, {
		"title" : "Koala",
		"image" : "Koala.jpg",
		"url" : "http://www.sxc.hu/photo/1042413",
		"firstline" : "Enjoy The Beuty of",
		"secondline" : "Naval Academy"
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
		$(this).css({ "background-image" : "url(images/slideshow/btn_pause.png)" });
		
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
	
	var showImage = function(photoObject, currentContainer, activeContainer) {
		animating = true;
				
		// Set the background image of the new active container
		$("#headerimg" + activeContainer).css({
			"background-image" : "url(images/slideshow/" + photoObject.image + ")",
			"display" : "block"
		});
				
		// Fade out the current container
		// and display the header text when animation is complete
		$("#headerimg" + currentContainer).fadeOut(function() {
			setTimeout(function() {
				/*$("#headertxt").css({"display" : "block"});*/
				animating = false;
			}, 500);
		});
	};
	
	var stopAnimation = function() {
		// Change the background image to "play"
		$("#control").css({ "background-image" : "url(images/slideshow/btn_play.png)" });
		
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