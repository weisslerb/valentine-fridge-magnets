/************************************************************
	Initialize Settings and Vars
************************************************************/
//msg_id = 38;
w = 1024;
h = 768;
fscommand("fullscreen", true);
import it.sephiroth.Serializer;
doc_root = "http://rgcreative.com/valentine/";
depth = 1000;
x_origin = _root.scene.origin._x;
y_origin = _root.scene.origin._y;
x_span = _root.scene.limit._x-x_origin;
y_span = _root.scene.limit._y-y_origin;
words_init_x = Array();
words_init_y = Array();
// array containing successfully placed clips
done_words = Array();
//
//
//
//
//
/************************************************************
	Scale content on movie resize, set scaling options
************************************************************/
var stageListener:Object = new Object();
stageListener.onResize = function() {
	x_scale = Stage.width/w*100;
	y_scale = Stage.height/h*100;
	scale = (x_scale>y_scale) ? y_scale : x_scale;
	scene._xscale = scale;
	scene._yscale = scale;
	// preserve mouse size
	scene.mouse.scaleTo(100*(100/scale), .5, "easeInOutCubic");
};
//
Stage.scaleMode = "noScale";
Stage.align = "BR";
//Stage.showMenu = false;
Stage.addListener(stageListener);
//
// Same as resize function, just needs to run at startup, too.
x_scale = Stage.width/w*100;
y_scale = Stage.height/h*100;
scale = (x_scale>y_scale) ? y_scale : x_scale;
scene._xscale = scale;
scene._yscale = scale;
//
//
//
//
//
/************************************************************
	Prep Mouse
************************************************************/
scene.mouse.swapDepths(10000);
scene.mouse._alpha = 0;
//
//
//
//
//
/************************************************************
	Function for removing duplicate values from  an array
************************************************************/
Array.prototype.array_unique = function() {
	g = 0;
	temp_ary = Array();
	for (i=0; i<this.length; i++) {
		checker = false;
		for (j=0; j<temp_ary.length; j++) {
			if (temp_ary[j] === this[i]) {
				checker = true;
			}
		}
		if (checker == false) {
			temp_ary[g++] = this[i];
		}
	}
	return temp_ary;
};
//
//
//
//
//
/************************************************************
	Mouse Click and Release functions for initial
	arrangement of messages
************************************************************/
MovieClip.prototype.press_mouse = function() {
	this.grab(false);
	clearInterval(this.press_timer);
};
MovieClip.prototype.release_mouse = function() {
	this.let_go(false);
	this.vinyl.enabled = true;
	clearInterval(this.release_timer);
};
//
//
//
//
//
/************************************************************
	Place Magnets
************************************************************/
function place_magnets() {
	delay_i = 0;
	for (i=0; i<num_words; i++) {
		word = words[i];
		//trace(word);
		num_letters = word.length;
		//
		if (msg_id>0) {
			x_pos = words_init_x[i];
			y_pos = words_init_y[i];
			//
			// if user sends a message after viewing a message,
			// we want the magnet arrangement to be as it was
			// when the original arrangement was finished, so..
			words_init_x[i] = words_x[i];
			words_init_y[i] = words_y[i];
			//
			depth = words_depth[i];
		} else {
			x_pos = Math.round(Math.random()*(x_span))+x_origin;
			y_pos = Math.round(Math.random()*(y_span))+y_origin;
			depth = i+500;
			//
			// Prevent hangoff on right edge of fridge
			half_width = _root.scene[word].vinyl._width/2;
			right_x = x_pos+half_width;
			right_edge = x_origin+x_span;
			if (right_x>right_edge) {
				x_pos -= (right_x-right_edge);
			}
			// Prevent hangoff on left edge of fridge
			left_x = x_pos-half_width;
			left_edge = x_origin;
			if (left_x<left_edge) {
				x_pos += Math.abs(left_edge-left_x);
			}
		}
		//
		_root.scene.attachMovie("lib_magnet", word, depth, {_x:x_pos, _y:y_pos});
		//
		//determine width of magnet based on word length
		extra_lengths = Array(0, 0, 9, 18, 27, 35, 44, 52, 61, 68, 77, 85, 94, 102, 110, 117, 126, 135, 145, 152, 159);
		extra = extra_lengths[num_letters];
		_root.scene[word].vinyl._width = .9*(18+extra);
		_root.scene[word].shadow._width = _root.scene[word].vinyl._width;
		_root.scene[word]._rotation = Math.round(Math.random()*(20))-10;
		//
		//
		if (msg_id>0) {
			// prevent usage of button before it has been placed
			_root.scene[word].vinyl.enabled = false;
			//
			x_target = words_x[i];
			y_target = words_y[i];
			//
			slide_time = .5;
			delay = (delay_i)+1.5;
			if ((Math.floor(x_target) != Math.floor(x_pos)) or (Math.floor(y_target) != Math.floor(y_pos))) {
				delay_i++;
				_root.scene[word].slideTo(x_target, y_target, slide_time, "easeInOutCubic", delay);
				_root.scene[word].rotateTo(0, .3, "easeInCubic", delay);
				//
				// slide mouse to next magnet
				_root.scene.mouse.slideTo(x_pos, y_pos, .5, "easeInOutCubic", delay-.5);
				//
				// drag current magnet
				_root.scene.mouse.slideTo(x_target, y_target, slide_time, "easeInOutCubic", delay);
			}
			//
			if (i == 0) {
				scene.mouse.alphaTo(100, .5, "easeInOutCubic");
			} else if ( i == (num_words - 1) ) {
				scene.mouse.alphaTo(0, .5, "easeInOutCubic");
			}
			//
			scene[word].press_timer = setInterval(scene[word], "press_mouse", delay*1000);
			scene[word].release_timer = setInterval(scene[word], "release_mouse", (delay*1000)+(slide_time*1000));
		}
		//
		_root.scene[word].vinyl.onPress = function() {
			this._parent.grab();
		};
		_root.scene[word].vinyl.onRelease = function() {
			this._parent.let_go();
		};
		_root.scene[word].vinyl.onReleaseOutside = function() {
			this._parent.let_go();
		};
		//
		// Prevent overlappage of existing magnets (no necessary if retrieving a message)
		if (msg_id == undefined) {
			done_length = done_words.length;
			bad_spot = false;
			snafu = 0;
			while (snafu<1) {
				//trace("*****************************************");
				//trace("Attempting to place " + word);
				//trace("*****************************************");
				for (i=0; i<done_length; i++) {
					clip = done_words[i];
					//trace ("Testing for contact with: " + clip);
					if (_root.scene[word].vinyl.hitTest(_root.scene[clip].vinyl) or _root.scene[word].vinyl.hitTest(_root.scene.logo) or _root.scene[word].vinyl.hitTest(_root.scene.finger)) {
						bad_spot = true;
						break;
					}
				}
				//
				if (bad_spot) {
					x_pos = Math.round(Math.random()*(x_span))+x_origin;
					y_pos = Math.round(Math.random()*(y_span))+y_origin;
					//
					// Prevent hangoff on right edge of fridge
					half_width = _root.scene[word].vinyl._width/2;
					right_x = x_pos+half_width;
					right_edge = x_origin+x_span;
					if (right_x>right_edge) {
						x_pos -= (right_x-right_edge);
					}
					// Prevent hangoff on left edge of fridge
					left_x = x_pos-half_width;
					left_edge = x_origin;
					if (left_x<left_edge) {
						x_pos += Math.abs(left_edge-left_x);
					}
					//
					_root.scene[word]._x = x_pos;
					_root.scene[word]._y = y_pos;
					bad_spot = false;
					snafu = 0;
					//trace(word + " collided with " + clip);
				} else {
					snafu = 1;
					//trace(word + " successfully placed.");
				}
				//trace("");
				//trace("");
			}
			// end while (snafu<1)
			//
			//
			done_words.push(word);
			words_init_x.push(x_pos);
			words_init_y.push(y_pos);
		}
		// end if (msg_id<1)
	}
	// end for (i=0; i<num_words; i++)
}
// end function place_magnets()
//
//
//
/************************************************************
	Check for existence of msg_id var, (set by flashvars)
	which is an indication of an attempt to view a saved
	message
************************************************************/
if (msg_id>0) {
	var serial:Serializer = new Serializer();
	from_php = new LoadVars();
	from_php.msg_id = msg_id;
	//
	// If the SWF file issuing this call is running in a web browser,
	// url must be in the same domain as the SWF file
	from_php.sendAndLoad(doc_root+"get_message.php", from_php, "POST");
	from_php.onLoad = function() {
		words = serial.unserialize(this.words);
		num_words = words.length;
		words_init_x = serial.unserialize(this.words_init_x);
		words_init_y = serial.unserialize(this.words_init_y);
		words_x = serial.unserialize(this.words_x);
		words_y = serial.unserialize(this.words_y);
		words_depth = serial.unserialize(this.words_depth);
		place_magnets();
		//trace("words: "+words);
	};
} else {
	/************************************************************
						Generate Words
					************************************************************/
	words = Array();
	// Error
	//words.push('invalid', 'message', 'number', 'please', 'visit', 'rgcreative', 'dot', 'com', 'slash', 'valentine', 'to', 'start', 'over');
	//words.push('is', 'this', 'test', 'a');
	//words.push('i','love','you');
	//words.push('hello', 'ryan', 'this', 'is', 'a', 'test', 'of', 'the', 'magnet', 'system', 'snootchie', 'bootchies', '!');
	//
	// Subjects
	words.push('rome & gold', 'i', 'me', 'mine', 'my', 'you', 'your', 'yours', 'we', 'our', 'us', 'ours', 'his', 'her');
	//
	// Verbs
	words.push('am', 'is', 'are', 'have', 'give', 'want', 'got', 'wants', 'relish', 'smell', 'let', 'touch', 'squeeze', 'fondle', 'crave', 'grow', 'smother');
	//
	// Adjectives
	words.push('big', 'sweet', 'hot', 'long', 'dear', 'flaming', 'strong');
	//
	// Articles
	words.push('a', 'while', 'as', 'at', 'to', 'in', 'on', 'with', 'under', 'because', 'by', 'like', 'and', 'but', 'or', 'the');
	//
	// Misc
	words.push('creative friction', 'design', 'message', 'weakness', 'target', 'audience', 'implement', 'visual', 'budget');
	words.push('goals', 'bottom line', 'brand', 'assets', 'values', 'hots');
	words.push('love', 'slave', 'position', 'body', 'marketing', 'points of contact', 'relationship', 'creative', 'please');
	words.push('ing', '?', '!');
	//
	//words = words.array_unique();
	num_words = words.length;
	// trace("Word Count: "+num_words);
	place_magnets();
}
//
//
//
//
/************************************************************
	Define Magnet Functions
************************************************************/
MovieClip.prototype.grab = function(byUser, rotate) {
	if (byUser == undefined or byUser == true) {
		this.startDrag();
		this.swapDepths(++_root.depth);
	}
	if (rotate == undefined or rotate == true) {
		this.rotateTo(0, .1, "easeInOutCubic");
	}
	this.shadow.alphaTo(50, .1, "linear");
	this.shadow.slideTo(3, 3, .1, "easeOutCubic");
	this.vinyl.slideTo(-1, -1, .1, "easeOutCubic");
	this.vinyl.gotoAndPlay("pickup");
};
//
MovieClip.prototype.let_go = function(byUser) {
	this.shadow.alphaTo(100, .2, "linear");
	this.shadow.slideTo(0, 0, .2, "easeOutCubic");
	this.vinyl.slideTo(0, 0, .2, "easeOutCubic");
	//
	this.x_to = this._x;
	this.y_to = this._y;
	//
	if (byUser == undefined or byUser == true) {
		stopDrag();
		//
		// Dropped beyond x bounds?
		if (this._x<_root.x_origin) {
			this.x_to = _root.x_origin+(this.vinyl._width/2);
			this.off_fridge = true;
		} else if (this._x>(_root.x_origin+_root.x_span)) {
			this.x_to = _root.x_origin+_root.x_span-(this.vinyl._width/2);
			this.off_fridge = true;
		}
		//
		// Dropped beyond y bounds?
		if (this._y<_root.y_origin) {
			this.y_to = _root.y_origin;
			this.off_fridge = true;
		} else if (_parent._y>(_root.y_origin+_root.y_span)) {
			this.y_to = _root.y_origin+_root.y_span;
			this.off_fridge = true;
		}
	}
	//
	if (this.off_fridge) {
		this.slideTo(this.x_to, this.y_to, .25, "easeInCubic");
		this.vinyl.gotoAndPlay("drop_delayed");
		this.off_fridge = false;
	} else {
		this.vinyl.gotoAndPlay("drop");
	}
};
//
//
//
//
//
/************************************************************
	Define Functions for Other Magnets
************************************************************/
extra_magnets = Array('sender', 'finger', 'finger_up');
num_extra_magnets = extra_magnets.length;
for (i=0; i<num_extra_magnets; i++) {
	magnet = extra_magnets[i];
	_root.scene[magnet].vinyl.name = magnet;
	_root.scene[magnet].vinyl.onPress = function() {
		this._parent.grab(true, false);
	};
	_root.scene[magnet].vinyl.onRelease = function() {
		this._parent.let_go();
		switch (this.name) {
		case "finger" :
			scene.slideTo(scene._x, 0, 1.5, "easeInOutCubic");
			break;
		case "finger_up" :
			scene.slideTo(scene._x, 760, 1.5, "easeInOutCubic");
			break;
		}
	};
	_root.scene[magnet].vinyl.onReleaseOutside = function() {
		this._parent.let_go();
	};
}
//
//
//
//
/************************************************************
	Send to PHP
************************************************************/
//
_root.scene.sender.onRelease = function() {
	var serial:Serializer = new Serializer();
	//
	words_x = Array();
	words_y = Array();
	words_depth = Array();
	//
	for (i=0; i<num_words; i++) {
		word = words[i];
		words_x.push(_root.scene[word]._x);
		words_y.push(_root.scene[word]._y);
		words_depth.push(_root.scene[word].getDepth());
	}
	//
	to_php = new LoadVars();
	to_php.words = serial.serialize(words);
	to_php.words_init_x = serial.serialize(words_init_x);
	to_php.words_init_y = serial.serialize(words_init_y);
	to_php.words_x = serial.serialize(words_x);
	to_php.words_y = serial.serialize(words_y);
	to_php.words_depth = serial.serialize(words_depth);
	// If the SWF file issuing this call is running in a web browser,
	// url must be in the same domain as the SWF file
	to_php.sendAndLoad(doc_root+"save_message.php", to_php, "POST");
	to_php.onLoad = refresh;
};
//
//
//
//
//
//
//
//
//
//
stop();
