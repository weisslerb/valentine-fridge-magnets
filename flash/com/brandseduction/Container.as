﻿package com.brandseduction {    import flash.display.*;  import flash.events.*;	import caurina.transitions.Tweener;		public class Container extends MovieClip {	  		function Container() {    }                             public function init() {      trace ("container init");       // Configure stage      stage.align = StageAlign.TOP_LEFT;      stage.scaleMode = StageScaleMode.NO_SCALE;      stage.addEventListener(Event.RESIZE, resizeHandler);      stage.addEventListener(MouseEvent.MOUSE_UP, releaseHandler);                  // Tiling Background      var bg:TilingBackground = new TilingBackground();      this.addChild(bg);      bg.init();                          // Preloader      var preloader:Preloader = new Preloader();      this.addChild(preloader);      preloader.init();    }    function load_finished() {      trace("cheese alligator")            // Fridge      var fridge:Fridge = new Fridge();      this.addChild(fridge);      fridge.init();            var logo:Logo = new Logo();      this.addChild(logo)      logo.init();                  // Harold and Mabel (and Jalouzie?)            // Footer            // Clothesline?    }    function resizeHandler(e:Event):void {      trace(stage.stageWidth/2);    }    		function releaseHandler(e:MouseEvent):void {			stopDrag();		}    	}	}