window.log = function(){
  log.history = log.history || [];  
  log.history.push(arguments);
  arguments.callee = arguments.callee.caller;  
  if(this.console) console.log( Array.prototype.slice.call(arguments) );
};
(function(b){function c(){}for(var d="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),a;a=d.pop();)b[a]=b[a]||c})(window.console=window.console||{});

(function($) {
		
	$.fn.extend({
   	
		lastChild:function(options) {
		
			/**
			* cssClass {String} - The CSS class to apply to the last child element
			* tags {Array} - The names of tags that are allowed to receive the class name
			*/
			var defaults = {cssClass:'last-child', tags:['div', 'li', 'p', 'th', 'tr', 'td']};
			
			if(typeof options === 'string') {
				options = $.extend(defaults, {cssClass:options});
			} else if(typeof options === 'object') {
				options = $.extend(defaults, options);
			} else {
				options = defaults;
			}
				
			return this.each(function() {
			
				var $children = $(this).children();
				
				if($children.length) {
				
					var $last = $children.last(), tag = $last[0].tagName.toLowerCase();
				
					for(var i = 0, len = options.tags.length; i < len; ++i) {
						
						if(options.tags[i] == tag) {
						
							if(!$last.hasClass(options.cssClass)) {
								$last.addClass(options.cssClass);
							}
							
							break;
						}
					}
					
					// Add last child class to children
					$children.each(function() {
						$(this).lastChild(options);
					});
				}
				
			});	// return
			
		}
	
	});
	
})(jQuery);


