var HK = {};

HK.jinit = function ()
{
    HK.btn = jQuery(".btn");
    TweenMax.staggerFrom(HK.btn, 2, {opacity:0, scaleX:0, scaleY:0, rotation:360}, 1);
    TweenMax.from(jQuery("#cover"), 2, {y:-500, ease: Bounce.easeOut});
};

jQuery(HK.jinit);
