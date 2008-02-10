﻿package {	import flash.display.MovieClip;	import caurina.transitions.Tweener;	public class Container extends MovieClip {        var _num_dots = 500	  var _golden = 137.50776 // super-duper magic number    var _expansion_rate = .6 // base spiral expansion rate (default 18/360)    var _divergence = .5 // exponent - 1.0 is linear, 0.5 is best    var _inside = 0//3 * _golden // size of hole in middle/*        var _num_dots = 100    var _golden = 137.50776 // super-duper magic number    var _expansion_rate = 18/360 // base spiral expansion rate (default 18/360)    var _divergence = .5 // exponent - 1.0 is linear, 0.5 is best    var _inside = 5 * _golden // size of hole in middle*/    var _dots:Array = new Array(); // container for reference to spawned dots	  		function Container(x_init:Number=0, y_init:Number=0) {      x = x_init;      y = y_init;            var x_positions:Array = new Array();      var y_positions:Array = new Array();            for (var i=0; i<_num_dots; i++) {        var rotation = i*_golden + _inside;        var step = rotation*_expansion_rate        var temp = (step > 0) ? Math.pow(step, _divergence) : -Math.pow(-step, _divergence);                x_positions.push(temp*Math.cos(rotation))        y_positions.push(temp*Math.sin(rotation))                var init_x = (i>8) ? x_positions[i-9] : x_positions[i];        var init_y = (i>8) ? y_positions[i-9] : y_positions[i];                var dot:Dot = new Dot(i, init_x, init_y, x_positions[i], y_positions[i], _num_dots);        _dots.push(dot)        this.addChild(dot);        dot.init()      }          }	}	}// Sunflower algorithm inspired by crazy postscript found at http://www.tinaja.com/glib/muse89.pdf// Translated from crazy postscript by the legendary Chris Eberz