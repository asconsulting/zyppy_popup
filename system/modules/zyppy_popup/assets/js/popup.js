(function($) {
		
	$.fn.contaoPopup = function() {
		
		var createCookie = function(name,value,days) {
			if (days) {
				var date = new Date();
				date.setTime(date.getTime()+(days*24*60*60*1000));
				var expires = "; expires="+date.toGMTString();
			}
			else var expires = "";
			document.cookie = name+"="+value+expires+"; path=/";
		}
		
		var readCookie = function (name) {
			var nameEQ = name + "=";
			var ca = document.cookie.split(';');
			for(var i=0;i < ca.length;i++) {
				var c = ca[i];
				while (c.charAt(0)==' ') c = c.substring(1,c.length);
				if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
			}
			return null;
		}
		
		return this.each(function() {
			if ($(this).is('.popup_frame')) {
				$(this).css('display', 'none');
				
				var popup = $(this);
				var puid = $(this).attr('puid');
				var popup_delay = $(this).attr('pdelay');					// Milliseconds
				var reshow_delay = parseInt($(this).attr('rdelay'));		// Minutes
				var scroll_trigger = parseInt($(this).attr('strigger'));	// Pixels
				var fade_duration = parseInt($(this).attr('fduration'));	// Milliseconds
				var popup_trigger = $(this).attr('ptrigger');				// CSS Selector

				var popup_timer = false;
				var scroll_start = false;
				var scroll_trip = false;
				var showPopup = true;
				
				if (popup_delay == '') {
					popup_delay = -1;
				} else {
					popup_delay = parseInt(popup_delay);
				}
				
				var activatePopup = function () {

					clearTimeout(popup_timer);
					var timeNow = Math.floor(Date.now() / 1000);
					
					if (reshow_delay) {
						var lastShown = parseInt(readCookie(puid + "_showTime"));
						var threshold = (parseInt(lastShown) + (reshow_delay * 60));
						if (threshold > timeNow) {
							showPopup = false;
						}
					}
									
					if (showPopup) {
						showPopup = false;
						if (fade_duration > 0) {
							popup.css({"opacity": "0", "display": "initial"}).fadeTo(fade_duration, 1).removeClass('popup_closed').addClass('popup_open');
						} else {
							popup.css("display", "block").removeClass('popup_closed').addClass('popup_open');
						}
						createCookie(puid + "_showTime", timeNow, (Math.floor(reshow_delay / 1440) + 1));
						
						$("body").on('click', function(e) {
							var close_popup = true;
							if ($(e.target).is(popup_trigger)) {
								close_popup = false;
							} else {
								$(e.target).parents().each(function() { 
									if ($(this).hasClass('popup_frame')) {
										close_popup = false;
									}
									if ($(this).is(popup_trigger)) {
										close_popup = false;
									}
								});
							}
							
							if (close_popup) {
								popup.css("display", "none").removeClass('popup_open').addClass('popup_closed');
								showPopup = true;
							}
						});
						
						popup.find(".close").click(function(el){
							el.preventDefault();
							popup.css("display", "none").removeClass('popup_open').addClass('popup_closed');
							showPopup = true;
						})
						
						popup.find('div.mod_zyppy_search div.results.popup_clear').empty();
					}
				};
			
				if (scroll_trigger) {
					scroll_start = $(window).scrollTop();
					scroll_trip = scroll_start + scroll_trigger;
					$(window).scroll(function() {
						if ($(window).scrollTop() > scroll_trip) {
							activatePopup();
						}
					});
				}
				
				if (popup_trigger) {
					$(popup_trigger).click(function() {
						activatePopup();
					});
				}
				
				if (popup_delay > 0) {
					popup_timer = setTimeout(activatePopup, popup_delay);
				} else if (popup_delay == 0) {
					activatePopup();
				}
				
				$(this).removeClass('pre_init').addClass('post_init');
			}
		});
	};		
		
	$(document).ready(function() {
		$('.popup_frame.pre_init').contaoPopup();
	});
})(jQuery);