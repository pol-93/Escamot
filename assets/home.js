import $ from "jquery";
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';


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
                    console.log($(this).attr('data-module'));
                    Application.module[$(this).attr('data-module')]($(this));
                });
            });

        },
        homeSlider: {
            init: function($module) {
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

            initSwiper: function($module) {
                console.log($module);
                console.log("bon dia Pol");

                var swiper = new Swiper($module[0], {
                    direction: "vertical",
                    speed: 1000,
                    parallax: true,
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
            var desplegable = $module.find(".select-transformation").data("replacedelement");
            $module.find(".select-transformation .option").on("click", function() {
                var $parentChildren = $(this).parent().parent().children();
                console.log($parentChildren);
                $parentChildren.each(function(element, self) {
                    $(self).find(".option").removeClass("active");
                });
                $(this).addClass("active");
                var optiontoCheck = $(this).data("value");
                console.log(optiontoCheck);

                $(desplegable).val(optiontoCheck);

                console.log($(desplegable).parent());

            });
            if (desplegable) {
                $(desplegable).parent().hide();
                $module.find(".select-transformation").detach().insertBefore($(desplegable).parent().parent().find("Button[type=submit]"));
            }

            $module.find("form>div").removeClass("text-entered");
            $module.animate({ opacity: 1 }, 1000);
        },
        checkEnteredText: function($module) {
            if ($module.val().length > 0) {
                $module.parent().addClass("text-entered");
            } else {
                $module.parent().removeClass("text-entered");
            }
        },
        aceEditor: function($module) {
            var ace = require('brace');
            require('brace/mode/javascript');
            require('brace/theme/monokai');
            var editor = ace.edit('javascript-editor');
            editor.getSession().setMode('ace/mode/javascript');
            editor.setTheme('ace/theme/monokai');
            editor.getSession().setUseWorker(false);
            console.log(editor.getValue());
            $module.find('form').on('submit', function() {
                $(this).find("#content").val(editor.getValue());
                return true;
            });
        },
        alertMessages: function($module) {
            $module.fadeIn();
            setTimeout(function() { $module.fadeOut(); }, 5000);
        }



    }


    return Application;
};