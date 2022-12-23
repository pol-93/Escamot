import $ from "jquery";
import Swiper from "swiper";


export default function() {

    var Application = {};

    Application.login = {
        init: function() {
            var self = this
            $(window).resize(function() {
                console.log("epp");
                self.loginSlider.AdjustWindow($('[data-module="loginSlider"]'));
            });
            self.loginSlider.init($('[data-module="loginSlider"]'));
        },
        loginSlider: {
            init: function($module) {
                this.AdjustWindow($module);
                this.initSwiper($module);
                this.getmouseWheel();
            },
            TransitionisActive: false,
            getmouseWheel: function() {
                var supportsWheel = false;

                function DoSomething(e) {
                    if (!Application.login.loginSlider.TransitionisActive) {
                        if (e.type == "wheel") supportsWheel = true;
                        else if (supportsWheel) return;
                        var delta = ((e.deltaY || -e.wheelDelta || e.detail) >> 10) || 1;
                        var HomeSwiperInstance = $('.mySwiper')[0].swiper;
                        if (delta == -1) {
                            HomeSwiperInstance.slidePrev();
                        } else if (delta == 1) {
                            HomeSwiperInstance.slideNext();
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
                console.log("bon dia Pol");
                var swiper = new Swiper(".mySwiper", {
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