import $ from "jquery";
import Swiper from "swiper";


export default function() {

    var Application = {};

    Application.home = {
        init: function() {
            var self = this
            $(window).resize(function() {
                console.log("resize callbacks");
                //self.homeSlider.AdjustWindow($('[data-module="loginSlider"]'));
            });
            self.homeSlider.init($('[data-module="homeSlider"]'));
        },
        homeSlider: {
            init: function($module) {
                //this.AdjustWindow($module);
                this.initSwiper($module);
                this.getmouseWheel($module);
            },
            TransitionisActive: false,
            getmouseWheel: function($module) {
                var supportsWheel = false;

                function DoSomething(e) {
                    if (!Application.home.homeSlider.TransitionisActive) {
                        Application.home.homeSlider.TransitionisActive = true;
                        if (e.type == "wheel") supportsWheel = true;
                        else if (supportsWheel) return;
                        var delta = ((e.deltaY || -e.wheelDelta || e.detail) >> 10) || 1;
                        var HomeSwiperInstance = $module[0].swiper;
                        if (delta == -1) {
                            HomeSwiperInstance.slidePrev();
                            setTimeout(function() {
                                Application.home.homeSlider.TransitionisActive = false;
                            }, 300);
                        } else if (delta == 1) {
                            HomeSwiperInstance.slideNext();
                            setTimeout(function() {
                                Application.home.homeSlider.TransitionisActive = false;
                            }, 300);
                        }
                    }
                }
                document.addEventListener('wheel', DoSomething);
                document.addEventListener('mousewheel', DoSomething);
                document.addEventListener('DOMMouseScroll', DoSomething);
            },
            AdjustWindow: function($module) {
                var ClientWindowHeight = window.innerHeight,
                    ClientWindowWidth = window.innerWidth;
                $.each($module.find('.swiper-slide'), function(idx, el) {
                    $(el).find(".bg").css("height", ClientWindowHeight);
                    $(el).find(".bg").css("width", ClientWindowWidth);
                });
                $('.swiper-container').first().css("height", ClientWindowHeight);
                $('.swiper-container').first().css("width", ClientWindowWidth);
            },
            initSwiper: function($module) {
                console.log($module);
                console.log("bon dia Pol");
                var swiper = new Swiper($module[0], {
                    direction: "vertical",
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                });
            }
        },
    }

    return Application;
};