$(function(){
	initSlideShow();
	popups ();
	initLogin ();
	initUp ();
	initAccordion ();
	initSettings ();
	initSocial ();
	initValidation();
	initVideoList();
	initLoginFormValidation();
	(function showBlock(){
		var block=$('.catalog-list .category');
		if(!block.size())return;
		block.each(function(){
			var counter=0;
			var _block=$(this),
				a=$(this).find('a'),
				a_h=222,
				a_w=222;
			a.css({'width':16,'height':16,"top":(a_h-16)/2,"left":(a_w-16)/2,"opacity":0});
			function scrollH(){
				if(_block.offset().top+_block.outerHeight()<$(window).height()+$(window).scrollTop()){
					$(window).off('scroll',scrollH);
					a.animate({'opacity':1,'width':a_w,'height':a_h},{duration:1000,step:function(now){
						$(this).css({'top':(a_h-now)/2,'left':(a_w-now)/2});
					},
					complete: function(){						quake();					}
					});
				}
			}
			function quake(){
				if(counter==10) return;
				counter++;				a.animate({'top':'-=5'},250,function(){					a.animate({'top':'+=5'},250,quake);				});			}
			$(window).scroll(scrollH);
			scrollH();
		});
	})();
});
function initLoginFormValidation(){
	var form=$('#login form'),
		input=form.find('input:text,input:password');
	form.submit(function(e){
		if(!form.hasClass('inProgress')){
			form.addClass('inProgress');
			$.ajax("login_test.php").done(function(data){
				var response=$.parseJSON(data);
				if(response.error){
					input.closest('.input-holder').addClass('error');
					form.find('.attention .text').show().text(response.status);
				}else{
					form.find('.attention .text').hide();
					input.closest('.input-holder').removeClass('error');
					window.location.reload();
				}
				form.removeClass('inProgress');
			}).error(function(e){
				alert(e.status);
			});
		}
		e.preventDefault();
	});
	form.find('input:submit').unbind('click');
}
function initVideoList(){
	var video=$('<object width="640" height="370">'+
					'<param name="allowfullscreen" value="true">'+
					'<param name="allowscriptaccess" value="always">'+
					'<param name="movie" value="">'+
					'<embed src="" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="640" height="370" />'+
				'</object>');
	$('.video-list li a').click(function(e){
		if(!$(this).parent().hasClass('active')){
			var clone=video.clone(),
				src=$(this).attr('href');
			clone.find('embed').attr('src',src).end().find('[name=movie]').attr('value',src);
			$(this).closest('ul').find('li').removeClass('active');
			$(this).parent().addClass('active');
			$(this).closest('ul').prev().find('>*').remove().end().append(clone);
		}
		e.preventDefault();
	});
}
function initValidation(){	var form=$('.register-form'),
		input=$('.row.required input');
		input.blur(function(){			if($(this).val().trim()=="" || $(this).val()==this.defaultValue){				$(this).closest('.input-holder').addClass('error');			}else{
				$(this).closest('.input-holder').removeClass('error');
			}		}).first().blur(function(){			if(!(/^[-\._a-z0-9]+@(?:[a-z0-9][-a-z0-9]+\.)+[a-z]{2,6}$/ig).test($(this).val()) || $(this).val()==this.defaultValue){
				$(this).closest('.input-holder').addClass('error');
			}else{
				$(this).closest('.input-holder').removeClass('error');
			}		});
		form.submit(function(e){
			input.trigger('blur');
			if (form.find('.error').size()) {
				e.preventDefault()
			}		});
		form.find('input:submit').unbind('click');}
function initSocial () {
	$('.share ul li a').click(function(e){
		var _num = parseInt($(this).parents('.share').find('.num').text());
		if(!$(this).closest('li').hasClass('active')){
			$(this).closest('li').addClass('active');
			$(this).parents('.share').find('.num').text(_num + 1);
		}
		e.preventDefault();
	})
}
function initSettings () {
	$('.settings-form .change-link a').click(function(e){
		$(this).parents('.row').addClass('active');
		$(this).parents('.row').find('.input-holder input').removeAttr('disabled');
		$(this).parents('.row').find('textarea').removeAttr('disabled');
		e.preventDefault();
	})
	$('.green-btn input').click(function(e){
		var _text = $(this).parents('.row').find('.input-holder input').val(),
			_text1 = $(this).parents('.row').find('textarea').val();
		$(this).parents('.row').find('.input-holder input').val(_text).attr('disabled', true);
		$(this).parents('.row').find('textarea').val(_text1).attr('disabled', true);
		$(this).parents('.row').removeClass('active');
		e.preventDefault();
	})
}
function initAccordion () {
	$('.accordion .heading').click(function(){
		if (!$(this).parent().hasClass('active')) {
			$(this).parents('.accordion').children('div.active').find('.expanded').slideUp(500, function(){
				$(this).parent().removeClass('active');
			});
			$(this).parent().find('.expanded').slideDown(500, function() {$(this).parent().addClass('active')});
		}
	})
}
function initUp () {
	$('.to-up-holder .to-up').click(function(e){
		$('html, body').animate({scrollTop: 0},500)
		e.preventDefault();
	})
	$(window).scroll(function(){
		if($(window).scrollTop() > 200 && $(window).width() > 1130){
			$('.to-up-holder .to-up').fadeIn(200);
		} else {
			$('.to-up-holder .to-up').fadeOut(200);
		}
	})
	$(window).resize(function(){
		if($(window).scrollTop() > 200 && $(window).width() > 1130){
			$('.to-up-holder .to-up').fadeIn(200);
		} else {
			$('.to-up-holder .to-up').fadeOut(200);
		}
	})
}
function initLogin () {
	$('#nav li.login a').click(function(e){
		$('#login').hide();
		$('.bg').height(popups());
		$('#login').css('left', '0').fadeIn(200);
		if ($('#login .popup').height() < $(window).height()) {
			$('#login .popup').css({top:($(window).height()/2-$('#login .popup').outerHeight()/2+$(window).scrollTop())});
		}
		e.preventDefault();
	});
	$('.bg, .popup .close').click(function(e){
		$(this).closest('.popup-holder').fadeOut(200, function(){
			$(this).css('left', '-9999px').show();
		})
		e.preventDefault();
	});
	$('#login .forgot').click(function(e){
		$(this).closest('.popup').find('.close').trigger('click');
		$('#remind').css('left', '0').hide().fadeIn(200);
		if ($('#remind .popup').height() < $(window).height()) {
			$('#remind .popup').css({top:($(window).height()/2-$('#remind .popup').outerHeight()/2+$(window).scrollTop())});
		}		e.preventDefault();	});
	$('.promo-code-opener').click(function(e){
		$('#promo-code').css('left', '0').hide().fadeIn(200);
		$('.bg').height(popups());
		if ($('#promo-code .popup').height() < $(window).height()) {
			$('#promo-code .popup').css({top:($(window).height()/2-$('#promo-code .popup').outerHeight()/2+$(window).scrollTop())});
		}		e.preventDefault();	});
}
function initSlideShow() {
	if($('.promo-gallery-holder .promo-gallery li').size()>1){
		$('.promo-gallery-holder').fadeGallery({
			slideElements:'.promo-gallery li',
			pagerLinks:'.switcher a',
			pauseOnHover:true,
			autoRotation:true,
			switchTime: 4000,
			duration:650,
			event:'click'
		});
	}else{
		$('.promo-gallery-holder').find('.switcher').hide();
	}
	$('.recipe-gallery-holder').galleryScroll({
		step: 1,
		slideNum: '.switcher-box',
		duration:800
	});
}
function popups () {
	var _w = $(window).height();
	if (_w < $(document).height()) {_w = $(document).height()}
	return _w;
}
$(window).resize(function(){
	$('.bg').height(popups());
});
jQuery.fn.galleryScroll = function(_options){
	// defaults options	
	var _options = jQuery.extend({
		btPrev: 'a.prev',
		btNext: 'a.next',
		holderList: 'div.recipe-gallery',
		scrollElParent: 'ul',
		scrollEl: 'li',
		slideNum: false,
		duration : 1000,
		step: false,
		circleSlide: true,
		disableClass: 'disable',
		funcOnclick: null,
		autoSlide:false,
		innerMargin:0,
		stepWidth:false
	},_options);

	return this.each(function(){
		var _this = jQuery(this);
		var _holderBlock = jQuery(_options.holderList,_this);
		var _gWidth = _holderBlock.width();
		var _animatedBlock = jQuery(_options.scrollElParent,_holderBlock);
		var _liWidth = jQuery(_options.scrollEl,_animatedBlock).outerWidth(true);
		var _liSum = jQuery(_options.scrollEl,_animatedBlock).length * _liWidth;
		var _margin = -_options.innerMargin;
		var f = 0;
		var _step = 0;
		var _autoSlide = _options.autoSlide;
		var _timerSlide = null;
		if (!_options.step) _step = _gWidth; else _step = _options.step*_liWidth;
		if (_options.stepWidth) _step = _options.stepWidth;
		
		if (!_options.circleSlide) {
			if (_options.innerMargin == _margin)
				jQuery(_options.btPrev,_this).addClass('prev-'+_options.disableClass);
		}
		if (_options.slideNum && !_options.step) {
			var _lastSection = 0;
			var _sectionWidth = 0;
			while(_sectionWidth < _liSum)
			{
				_sectionWidth = _sectionWidth + _gWidth;
				if(_sectionWidth > _liSum) {
				       _lastSection = _sectionWidth - _liSum;
				}
			}
		}
		if (_autoSlide) {
				_timerSlide = setTimeout(function(){
					autoSlide(_autoSlide);
				}, _autoSlide);
			_animatedBlock.hover(function(){
				clearTimeout(_timerSlide);
			}, function(){
				_timerSlide = setTimeout(function(){
					autoSlide(_autoSlide)
				}, _autoSlide);
			});
		}
	
		// click button 'Next'
		jQuery(_options.btNext,_this).bind('click',function(){
			jQuery(_options.btPrev,_this).removeClass('prev-'+_options.disableClass);
			if (!_options.circleSlide) {
				if (_margin + _step  > _liSum - _gWidth - _options.innerMargin) {
					if (_margin != _liSum - _gWidth - _options.innerMargin) {
						_margin = _liSum - _gWidth  + _options.innerMargin;
						jQuery(_options.btNext,_this).addClass('next-'+_options.disableClass);
						_f2 = 0;
					} 
				} else {
					_margin = _margin + _step;
					if (_margin == _liSum - _gWidth - _options.innerMargin) {
						jQuery(_options.btNext,_this).addClass('next-'+_options.disableClass);_f2 = 0;
					} 					
				}
			} else {
				if (_margin + _step  > _liSum - _gWidth + _options.innerMargin) {
					if (_margin != _liSum - _gWidth + _options.innerMargin) {
						_margin = _liSum - _gWidth  + _options.innerMargin;
					} else {
						_f2 = 1;
						_margin = -_options.innerMargin;
					}
				} else {
					_margin = _margin + _step;
					_f2 = 0;
				}
			} 
			
			_animatedBlock.animate({marginLeft: -_margin+"px"}, {queue:false,duration: _options.duration });
			
			if (_timerSlide) {
				clearTimeout(_timerSlide);
				_timerSlide = setTimeout(function(){
					autoSlide(_options.autoSlide)
				}, _options.autoSlide);
			}
			
			if (_options.slideNum){
				jQuery.fn.galleryScroll.numListActive(_margin,jQuery(_options.slideNum, _this),_gWidth,_lastSection);	
				
			} 	
			if (jQuery.isFunction(_options.funcOnclick)) {
				_options.funcOnclick.apply(_this);
			}
			return false;
		});
		// click button 'Prev'
		var _f2 = 1;
		jQuery(_options.btPrev, _this).bind('click',function(){
			jQuery(_options.btNext,_this).removeClass('next-'+_options.disableClass);
			if (_margin - _step >= -_step - _options.innerMargin && _margin - _step <= -_options.innerMargin) {
				if (_f2 != 1) {
					_margin = -_options.innerMargin;
					_f2 = 1;
				} else {
					if (_options.circleSlide) {
						_margin = _liSum - _gWidth  + _options.innerMargin;
						f=1;_f2=0;
					} else {
						_margin = -_options.innerMargin
					}
				}
			} else if (_margin - _step < -_step + _options.innerMargin) {
				_margin = _margin - _step;
				f=0;
			}
			else {_margin = _margin - _step;f=0;};
			
			if (!_options.circleSlide && _margin == _options.innerMargin) {
				jQuery(this).addClass('prev-'+_options.disableClass);
				_f2=0;
			}
			
			if (!_options.circleSlide && _margin == -_options.innerMargin) jQuery(this).addClass('prev-'+_options.disableClass);
			_animatedBlock.animate({marginLeft: -_margin + "px"}, {queue:false, duration: _options.duration});
			
			if (_options.slideNum) jQuery.fn.galleryScroll.numListActive(_margin,jQuery(_options.slideNum, _this),_gWidth,_lastSection);
			
			if (_timerSlide) {
				clearTimeout(_timerSlide);
				_timerSlide = setTimeout(function(){
					autoSlide(_options.autoSlide)
				}, _options.autoSlide);
			}
			
			if (jQuery.isFunction(_options.funcOnclick)) {
				_options.funcOnclick.apply(_this);
			}
			return false;
		});
		
		if (_liSum <= _gWidth) {
			jQuery(_options.btPrev,_this).addClass('prev-'+_options.disableClass).unbind('click');
			jQuery(_options.btNext,_this).addClass('next-'+_options.disableClass).unbind('click');
		}
		// auto slide
		function autoSlide(autoSlideDuration){
			//if (_options.circleSlide) {
				jQuery(_options.btNext,_this).trigger('click');
			//}
		};
		// Number list
		jQuery.fn.galleryScroll.numListCreate = function(_elNumList, _liSumWidth, _width, _section){
			var _numListElC = '';
			var _num = 1;
			var _difference = jQuery(_options.scrollEl,_animatedBlock).size();
			if(_difference>1){
				while(_difference)
				{
					_numListElC += '<li><a href="">'+_num+'</a></li>';
					_num++;
					_difference--;
				}
				jQuery(_elNumList).html('<ul>'+_numListElC+'</ul>');
			}else{
				jQuery(_elNumList).hide();
			}
			
		};
		jQuery.fn.galleryScroll.numListActive = function(_marginEl, _slideNum, _width, _section){
			if (_slideNum) {
				jQuery('a',_slideNum).removeClass('active');
				var _activeRange = _width - _section-1;
				var _n = 0;
				if (_marginEl != 0) {
					while (_marginEl > _activeRange) {
						_activeRange = (_n * _width) -_section-1 + _options.innerMargin;
						_n++;
					}
				}
				var _a  = _marginEl/_width;
				jQuery('a',_slideNum).eq(_a).addClass('active');
			}
		};
		if (_options.slideNum) {
			jQuery.fn.galleryScroll.numListCreate(jQuery(_options.slideNum, _this), _liSum, _gWidth,_lastSection);
			jQuery.fn.galleryScroll.numListActive(_margin, jQuery(_options.slideNum, _this),_gWidth,_lastSection);
			numClick();
		};
		function numClick() {
			jQuery(_options.slideNum, _this).find('a').click(function(){
				jQuery(_options.btPrev,_this).removeClass('prev-'+_options.disableClass);
				jQuery(_options.btNext,_this).removeClass('next-'+_options.disableClass);
				
				var _indexNum = jQuery(_options.slideNum, _this).find('a').index(jQuery(this));
				_margin = (_step*_indexNum) - _options.innerMargin;
				f=0; _f2=0;
				if (_indexNum == 0) _f2=1;
				if (_margin + _step > _liSum) {
					_margin = _margin - (_margin - _liSum) - _step + _options.innerMargin;
					if (!_options.circleSlide) jQuery(_options.btNext, _this).addClass('next-'+_options.disableClass);
				}
				_animatedBlock.animate({marginLeft: -_margin + "px"}, {queue:false, duration: _options.duration});
				
				if (!_options.circleSlide && _margin==0) jQuery(_options.btPrev,_this).addClass('prev-'+_options.disableClass);
				jQuery.fn.galleryScroll.numListActive(_margin, jQuery(_options.slideNum, _this),_gWidth,_lastSection);
				
				if (_timerSlide) {
					clearTimeout(_timerSlide);
					_timerSlide = setTimeout(function(){
						autoSlide(_options.autoSlide)
					}, _options.autoSlide);
				}
				return false;
			});
		};
	});
}
jQuery.fn.fadeGallery = function(_options){
	var _options = jQuery.extend({
		slideElements:'div.slideset > div',
		pagerLinks:'ul.switcher a',
		btnNext:'a.next',
		btnPrev:'a.prev',
		btnPlayPause:'a.play-pause',
		pausedClass:'paused',
		playClass:'playing',
		activeClass:'active',
		pauseOnHover:true,
		autoRotation:false,
		autoHeight:false,
		switchTime:3000,
		duration:650,
		event:'click'
	},_options);

	return this.each(function(){
		var _this = jQuery(this);
		var _slides = jQuery(_options.slideElements, _this);
		var _pagerLinks = jQuery(_options.pagerLinks, _this);
		var _btnPrev = jQuery(_options.btnPrev, _this);
		var _btnNext = jQuery(_options.btnNext, _this);
		var _btnPlayPause = jQuery(_options.btnPlayPause, _this);
		var _pauseOnHover = _options.pauseOnHover;
		var _autoRotation = _options.autoRotation;
		var _activeClass = _options.activeClass;
		var _pausedClass = _options.pausedClass;
		var _playClass = _options.playClass;
		var _autoHeight = _options.autoHeight;
		var _duration = _options.duration;
		var _switchTime = _options.switchTime;
		var _controlEvent = _options.event;

		var _hover = false;
		var _prevIndex = 0;
		var _currentIndex = 0;
		var _slideCount = _slides.length;
		var _timer;
		if(!_slideCount) return;
		_slides.hide().eq(_currentIndex).show();
		if(_autoRotation) _this.removeClass(_pausedClass).addClass(_playClass);
		else _this.removeClass(_playClass).addClass(_pausedClass);

		if(_btnPrev.length) {
			_btnPrev.bind(_controlEvent,function(){
				prevSlide();
				return false;
			});
		}
		if(_btnNext.length) {
			_btnNext.bind(_controlEvent,function(){
				nextSlide();
				return false;
			});
		}
		if(_pagerLinks.length) {
			_pagerLinks.each(function(_ind){
				jQuery(this).bind(_controlEvent,function(){
					if(_currentIndex != _ind) {
						_prevIndex = _currentIndex;
						_currentIndex = _ind;
						switchSlide();
					}
					return false;
				});
			});
		}

		if(_btnPlayPause.length) {
			_btnPlayPause.bind(_controlEvent,function(){
				if(_this.hasClass(_pausedClass)) {
					_this.removeClass(_pausedClass).addClass(_playClass);
					_autoRotation = true;
					autoSlide();
				} else {
					if(_timer) clearRequestTimeout(_timer);
					_this.removeClass(_playClass).addClass(_pausedClass);
				}
				return false;
			});
		}

		function prevSlide() {
			_prevIndex = _currentIndex;
			if(_currentIndex > 0) _currentIndex--;
			else _currentIndex = _slideCount-1;
			switchSlide();
		}
		function nextSlide() {
			_prevIndex = _currentIndex;
			if(_currentIndex < _slideCount-1) _currentIndex++;
			else _currentIndex = 0;
			switchSlide();
		}
		function refreshStatus() {
			if(_pagerLinks.length) _pagerLinks.removeClass(_activeClass).eq(_currentIndex).addClass(_activeClass);
			_slides.eq(_prevIndex).removeClass(_activeClass);
			_slides.eq(_currentIndex).addClass(_activeClass);
		}
		function switchSlide() {
			_slides.stop(true,true);
			_slides.eq(_prevIndex).fadeOut(_duration);
			_slides.eq(_currentIndex).fadeIn(_duration);
			refreshStatus();
			autoSlide();
		}

		function autoSlide() {
			if(!_autoRotation || _hover) return;
			if(_timer) clearRequestTimeout(_timer);
			_timer = requestTimeout(nextSlide,_switchTime+_duration);
		}
		if(_pauseOnHover) {
			_this.hover(function(){
				_hover = true;
				if(_timer) clearRequestTimeout(_timer);
			},function(){
				_hover = false;
				autoSlide();
			});
		}
		refreshStatus();
		autoSlide();
	});
}
/*
 * Drop in replace functions for setTimeout() & setInterval() that
 * make use of requestAnimationFrame() for performance where available
 * http://www.joelambert.co.uk
 *
 * Copyright 2011, Joe Lambert.
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 */

// requestAnimationFrame() shim by Paul Irish
// http://paulirish.com/2011/requestanimationframe-for-smart-animating/
window.requestAnimFrame = (function() {
	return  window.requestAnimationFrame   ||
			window.webkitRequestAnimationFrame ||
			window.mozRequestAnimationFrame    ||
			window.oRequestAnimationFrame      ||
			window.msRequestAnimationFrame     ||
			function(/* function */ callback, /* DOMElement */ element){
				window.setTimeout(callback, 1000 / 60);
			};
})();
/**
 * Behaves the same as setTimeout except uses requestAnimationFrame() where possible for better performance
 * @param {function} fn The callback function
 * @param {int} delay The delay in milliseconds
 */

window.requestTimeout = function(fn, delay) {
	if( !window.requestAnimationFrame      	&&
		!window.webkitRequestAnimationFrame &&
		!window.mozRequestAnimationFrame    &&
		!window.oRequestAnimationFrame      &&
		!window.msRequestAnimationFrame)
			return window.setTimeout(fn, delay);

	var start = new Date().getTime(),
		handle = new Object();

	function loop(){
		var current = new Date().getTime(),
			delta = current - start;

		delta >= delay ? fn.call() : handle.value = requestAnimFrame(loop);
	};

	handle.value = requestAnimFrame(loop);
	return handle;
};

/**
 * Behaves the same as clearInterval except uses cancelRequestAnimationFrame() where possible for better performance
 * @param {int|object} fn The callback function
 */
window.clearRequestTimeout = function(handle) {
    window.cancelAnimationFrame ? window.cancelAnimationFrame(handle.value) :
    window.webkitCancelRequestAnimationFrame ? window.webkitCancelRequestAnimationFrame(handle.value)	:
    window.mozCancelRequestAnimationFrame ? window.mozCancelRequestAnimationFrame(handle.value) :
    window.oCancelRequestAnimationFrame	? window.oCancelRequestAnimationFrame(handle.value) :
    window.msCancelRequestAnimationFrame ? msCancelRequestAnimationFrame(handle.value) :
    clearTimeout(handle);
};