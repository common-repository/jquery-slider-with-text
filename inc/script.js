if(typeof(jQuery) == "undefined") {
    var el = document.createElement("script");
    el.src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js";
    document.getElementsByTagName("head")[0].appendChild(el);
}
else {
    var $ = jQuery;
}
var launcher = setTimeout(function () {
    if(typeof($) != "undefined") {
        clearInterval(launcher);
        startSpinInteractiveSlider();
    }
}, 100);

var position = 0;
var loop = 1;

function startSpinInteractiveSlider() {

    var slideSize = [$(".spininteractive-slider").width(), $(".spininteractive-slider").height()];
    var imageCount = $(".spininteractive-slider ul li img").length;
    var containerWidth = slideSize[0] * imageCount;
    var slider = $(".spininteractive-slider ul");
    var sliderContent = slider.html();
    slider.css("width", containerWidth + "px");
    slider.css("height", slideSize[1] + "px");
    $(".spininteractive-slider ul img").css("width", slideSize[0] + "px");
    $(".spininteractive-slider ul img").css("height", slideSize[1] + "px");
    $(".spininteractive-slider .arrows").css("top", - 10 + (0.5 * slideSize[1]) + "px");

    var sliderAnimation = function(mode) {
        if(mode == "reverse") {
            if(position > 0) {
                position--;
                slider.animate({"right": "-="+slideSize[0]});
            }
        }
        else {
            slider.animate({"right": "+="+slideSize[0]});
            position++;
            if((position+1) == imageCount) {
                loop++;
                slider.css("width", loop * containerWidth + "px");
                slider.append(sliderContent);
                $(".spininteractive-slider ul img").css("width", slideSize[0] + "px");
                $(".spininteractive-slider ul img").css("height", slideSize[1] + "px");
                imageCount = $(".spininteractive-slider ul li img").length;
            }
        }
    };
    var animation = setInterval(sliderAnimation, 5000);
    $(".spininteractive-slider").mouseover(function() {
        clearInterval(animation);
        $(".spininteractive-slider .arrows").fadeIn(100);
    });

    $(".spininteractive-slider ul li img").click(function() {
        if($(this).data("url") != "") {
            open($(this).data("url"), "_blank");
        }
    });

    $(".spininteractive-slider").mouseleave(function() {
        animation = setInterval(sliderAnimation, 5000);
        $(".spininteractive-slider .arrows").fadeOut(100);
    });

    $(".spininteractive-slider .arrows").mouseover(function() {
        clearInterval(animation);
    });

    $(".spininteractive-slider .arrow-left").click(function() {
        sliderAnimation("reverse");
    });

    $(".spininteractive-slider .arrow-right").click(function() {
        sliderAnimation();
    });

}