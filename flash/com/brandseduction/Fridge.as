﻿package com.brandseduction {  	import flash.display.MovieClip;  import flash.display.Stage;	import caurina.transitions.Tweener;	import flash.events.MouseEvent;		public class Fridge extends MovieClip {	    	var _id:Number;  	var _diameter:Number;    var _words:Array = new Array();    var _magnets:Array = new Array();    // These will be the magnet area's boundary lines    var _padding = 20;    var _top_edge;    var _right_edge;    var _bottom_edge;    var _left_edge;  			function Fridge() {      this.addEventListener(MouseEvent.CLICK, onClick);      this.addEventListener(MouseEvent.ROLL_OVER, onRollOver);		}				// This function is called by the parent container post-instantiation,		// as 'parent' is not available in the constructor function. Duh.		public function init() {      trace ("fridge init");      y = stage.stageHeight - height + 50;      x = stage.stageWidth - width - 30;                                     // Define boundaries for magnets      _top_edge = _left_edge = _padding;      _right_edge = width - _padding*2;      _bottom_edge = height - _padding*2;            spawn_magnets();      // Magnets      // Sender      // Other stuff?		}				function x_span() {		  return _right_edge - _left_edge;		}				function y_span() {		  return _bottom_edge - _top_edge;		}    function spawn_magnets() {    	// Subjects    	_words.push('rome & gold', 'i', 'me', 'mine', 'my', 'you', 'your', 'yours', 'we', 'our', 'us', 'ours', 'his', 'her');    	// Verbs    	_words.push('am', 'is', 'are', 'have', 'give', 'want', 'got', 'wants', 'relish', 'smell', 'let', 'touch', 'squeeze', 'fondle', 'crave', 'grow', 'smother');    	// Adjectives    	_words.push('big', 'sweet', 'hot', 'long', 'dear', 'flaming', 'strong');    	// Articles    	_words.push('a', 'while', 'as', 'at', 'to', 'in', 'on', 'with', 'under', 'because', 'by', 'like', 'and', 'but', 'or', 'the');    	// Misc    	_words.push('creative friction', 'design', 'message', 'weakness', 'target', 'audience', 'implement', 'visual', 'budget');    	_words.push('goals', 'bottom line', 'brand', 'assets', 'values', 'hots');    	_words.push('love', 'slave', 'position', 'body', 'marketing', 'points of contact', 'relationship', 'creative', 'please');    	_words.push('ing', '?', '!');    	    	_words = ["this", "that", "other"];/*      _words.push('big', 'sweet', 'hot', 'long', 'dear', 'flaming', 'strong');*/         	delay_i = 0;    	for (var i=0; i<_words.length; i++) {    		word = _words[i];/*        trace(word);*/        var magnet:Magnet = new Magnet(i, word);        this.addChild(magnet);        magnet.init();        this._magnets.push(magnet)    	 }    }        						function onRollOver(event:MouseEvent):void {}		    function onClick(event:MouseEvent):void {}	}	}