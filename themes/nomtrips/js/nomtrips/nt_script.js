/*********
 *  miscellaneous js scripts
*********/

jQuery(document).ready( function( $ ) {

  /*
   *  image captions in blog posts(reviews. dishes, blogs)
   */
  $(".single .content--post img").each(function () {
    if($(this).attr("alt").length > 0) {
      //get caption
      var caption = $(this).attr("alt");

      //create new element to contain image and add class to it
      var imageDiv = document.createElement("div");
      $(imageDiv).addClass("content--post-img");

      //create caption element and html
      var captionDiv = document.createElement("div");
      $(captionDiv).addClass("content--post-img-caption").html(caption);


      //add it to before the image
      $(imageDiv).insertBefore($(this));

      //add caption and image to image div
      $(this).appendTo(imageDiv);
      $(captionDiv).appendTo(imageDiv);
    }
  });


  /*
   *  events drag vs click
   *  anytime a mousedown occurs x/y coordinates change after mouseup, drag is assumed.
   */
  var clickOrDrag = function(element) {
    var clientX = -1;
    var clientY = -1;
    var threshold = 10;

    element.addEventListener("mousedown", function(e) {
        element.dragFlag = 0;
        clientX = e.clientX;
        clientY = e.clientY;
        //console.log("X: " + e.clientX + " / Y: " + e.clientY);

    }, false);

    element.addEventListener("mouseup", function(e) {
      //console.log("X: " + e.clientX + " / Y: " + e.clientY);
      if(e.clientX > (clientX - threshold) && e.clientX < (clientX + threshold) &&
      e.clientY > (clientY - threshold) && e.clientY < (clientY + threshold))
      {
        element.dragFlag = 0;
      }

      else {
        element.dragFlag = 1;
      }
    }, false);
  };

  /*
   *  for all of these elements, add event listeners add click event if not dragged.
   */
  $(".card--location").each(function() {
    var dragged = clickOrDrag(this);

    $(this).click(function() {
      if(!this.dragFlag) {
        window.location.href = $(this).data("url");
      }
    });
  });


  /*
   *  Adding a stylesheet to override tooltip ::before psuedoelement.
   *  Not sure how else to modify the tool tips
   *  Other things can piggyback this stylesheet also
   */
  var overrideTripStylesheet = (function() {

    var style = document.createElement("style");

    // WebKit hack
    style.appendChild(document.createTextNode(""));

    // Add the <style> element to the page
    document.head.appendChild(style);

    // console.log(style.sheet.cssRules); // length is 0, and no rules

    return style.sheet;
  })();


  /*
   *  Tooltips - overrides/adds foundation tooltip
   */
  function setToolTipColors() {
    // console.log("ss");
    $(".has-tip").each(function(){
      if($(this).data("match-bg")) {
        var color = $(this).children(".fa").css("color");
        var target = $(this).data("toggle");
        $("#" + target).css({"background-color" : color});
        overrideTripStylesheet.insertRule('#' + target + '::before{border-color: transparent transparent ' + color + ';}', 0);
      }
    });
  }

  //timeout - wait for foundation js to its thang first
  //setTimeout(setToolTipColors, 1000);
});