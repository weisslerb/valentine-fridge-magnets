﻿package {  	import flash.events.Event;	import flash.display.MovieClip;  import com.brandseduction.Container;	public class Document extends MovieClip {		public function Document() {			var container:Container = new Container();			this.addChild(container);			container.init();		}	}}