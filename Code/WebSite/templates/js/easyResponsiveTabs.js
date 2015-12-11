// Easy Responsive Tabs Plugin
// Author: Samson.Onna
(function ($) {
    $.fn.extend({
        easyResponsiveTabs: function (options) {
            //Set the default values, use comma to separate the settings, example:
            var defaults = {
                type: 'default', //default, vertical, accordion;
                width: 'auto',
                fit: true
            }
            //Variables
            var options = $.extend(defaults, options);            
            var opt = options, jtype = opt.type, jfit = opt.fit, jwidth = opt.width, vtabs = 'vertical', accord = 'accordion';

            //Main function
            this.each(function () {
                var $respTabs = $(this);
                $respTabs.find('ul.resp-tabs-list li').addClass('pick-choice');
                $respTabs.css({
                    'display': 'block',
                    'width': jwidth
                });

                $respTabs.find('.choice-list-container > div').addClass('choice-list-content');
                jtab_options();
                //Properties Function
                function jtab_options() {
                    if (jtype == vtabs) {
                        $respTabs.addClass('resp-vtabs');
                    }
                    if (jfit == true) {
                        $respTabs.css({ width: '100%', margin: '0px' });
                    }
                    if (jtype == accord) {
                        $respTabs.addClass('resp-easy-accordion');
                        $respTabs.find('.resp-tabs-list').css('display', 'none');
                    }
                }

                //Assigning the h2 markup
                var $tabItemh2;
                $respTabs.find('.choice-list-content').before("<h2 class='choice-accordion' role='tab'><span class='resp-arrow'></span></h2>");

                var itemCount = 0;
                $respTabs.find('.choice-accordion').each(function () {
                    $tabItemh2 = $(this);
                    var innertext = $respTabs.find('.pick-choice:eq(' + itemCount + ')').text();
                    $respTabs.find('.choice-accordion:eq(' + itemCount + ')').append(innertext);
                    $tabItemh2.attr('aria-controls', 'tab_item-' + (itemCount));
                    itemCount++;
                });

                //Assigning the 'aria-controls' to Tab items
                var count = 0,
                    $tabContent;
                $respTabs.find('.pick-choice').each(function () {
                    $tabItem = $(this);
                    $tabItem.attr('aria-controls', 'tab_item-' + (count));
                    $tabItem.attr('role', 'tab');

                    //First active tab                   
                    $respTabs.find('.pick-choice').first().addClass('choice-list-active');
                    $respTabs.find('.choice-accordion').first().addClass('choice-list-active');
                    $respTabs.find('.choice-list-content').first().addClass('choice-list-content-active').attr('style', 'display:block');

                    //Assigning the 'aria-labelledby' attr to tab-content
                    var tabcount = 0;
                    $respTabs.find('.choice-list-content').each(function () {
                        $tabContent = $(this);
                        $tabContent.attr('aria-labelledby', 'tab_item-' + (tabcount));
                        tabcount++;
                    });
                    count++;
                });

                //Tab Click action function
                $respTabs.find("[role=tab]").each(function () {
                    var $currentTab = $(this);
                    $currentTab.click(function () {

                        var $tabAria = $currentTab.attr('aria-controls');

                        if ($currentTab.hasClass('choice-accordion') && $currentTab.hasClass('choice-list-active')) {
                            $respTabs.find('.choice-list-content-active').slideUp('', function () { $(this).addClass('choice-accordion-closed'); });
                            $currentTab.removeClass('choice-list-active');
                            return false;
                        }
                        if (!$currentTab.hasClass('choice-list-active') && $currentTab.hasClass('choice-accordion')) {
                            $respTabs.find('.choice-list-active').removeClass('choice-list-active');
                            $respTabs.find('.choice-list-content-active').slideUp().removeClass('choice-list-content-active choice-accordion-closed');
                            $respTabs.find("[aria-controls=" + $tabAria + "]").addClass('choice-list-active');

                            $respTabs.find('.choice-list-content[aria-labelledby = ' + $tabAria + ']').slideDown().addClass('choice-list-content-active');
                        } else {
                            $respTabs.find('.choice-list-active').removeClass('choice-list-active');
                            $respTabs.find('.choice-list-content-active').removeAttr('style').removeClass('choice-list-content-active').removeClass('choice-accordion-closed');
                            $respTabs.find("[aria-controls=" + $tabAria + "]").addClass('choice-list-active');
                            $respTabs.find('.choice-list-content[aria-labelledby = ' + $tabAria + ']').addClass('choice-list-content-active').attr('style', 'display:block');
                        }
                    });
                    //Window resize function                   
                    $(window).resize(function () {
                        $respTabs.find('.choice-accordion-closed').removeAttr('style');
                    });
                });
            });
        }
    });
})(jQuery);

