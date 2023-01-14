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

            $(function() {
                $('[data-module]').each(function() {
                    Application.module[$(this).attr('data-module')]($(this));
                });
            });

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

    Application.module = {
        form: function($module) {
            var self = this;
            $module.find("input").on('keyup keypress blur change', function(e) {
                self.checkEnteredText($(this));
            });
            $module.find("input").each(function() {
                self.checkEnteredText($(this));
                $(this).parent().prepend($(this).detach());
            });
            $module.find("button").each(function() {
                $(this).removeClass();
                $(this).addClass("btn btn-dark btn-block form-control");
            });
            $module.find("form>div").removeClass("text-entered");
            $module.animate({ opacity: 1 }, 1000);
        },
        checkEnteredText: function($module) {
            console.log("ep");
            if ($module.val().length > 0) {
                $module.parent().addClass("text-entered");
            } else {
                $module.parent().removeClass("text-entered");
            }
        }

    }


    return Application;
};