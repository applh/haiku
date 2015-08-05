var HK = {};

HK.jinit = function ()
{
    HK.btn = jQuery(".btn");
    TweenMax.staggerFrom(HK.btn, 1, {opacity:0, scaleX:0, scaleY:0, rotation:360}, 1);

};

jQuery(HK.jinit);
