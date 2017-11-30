/*var $ = jQuery;
$(document).ready(function() {
console.log(oauthRequest);
var form = new FormData();
form.append("oauth_consumer_key", "EBuxrdTuFrEU");
form.append("oauth_token", "");
form.append("oauth_signature_method", "HMAC-SHA1");
form.append("oauth_timestamp", 1502796596);
form.append("oauth_nonce", "E0WRKi");
form.append("oauth_version", "1.0");
form.append("oauth_signature", "fb8vxYeh9IsxAoXR0ygs40GvTU4=");

var settings = {
  "async": true,
  "crossDomain": true,
  "url": "http://localhost:8888/nomtrips/oauth1/request/?oauth_consumer_key=EBuxrdTuFrEU&oauth_signature_method=HMAC-SHA1&oauth_timestamp=1502811167&oauth_nonce=LXreqR&oauth_version=1.0&oauth_signature=UBuePNWJKXFvOhi4L6nV2tAik0E%3D",
  "method": "GET",
  "headers": {
    "cache-control": "no-cache",
    "postman-token": "10f89b1b-23d6-4d45-849d-734d7100256f"
  },
  "processData": false,
  "contentType": false,
  "mimeType": "multipart/form-data",
  "data": form
}

$.ajax(settings).done(function (response) {
  console.log(response);
});
});
*/

/* var form = new FormData();
form.append("oauth_consumer_key", oauthRequest.oauth_consumer_key);
form.append("oauth_signature_method", oauthRequest.oauth_signature_method);
form.append("oauth_timestamp", oauthRequest.oauth_timestamp);
form.append("oauth_nonce", oauthRequest.oauth_nonce);
form.append("oauth_version", oauthRequest.oauth_version);
form.append("oauth_signature", oauthRequest.oauth_signature + "="); */
/* 
var xhr = new XMLHttpRequest();
xhr.withCredentials = true;

xhr.addEventListener("readystatechange", function () {
  if (this.readyState === 4) {
    console.log(this.responseText);
  }
});

xhr.open("GET", oauthRequest.base_string);
xhr.setRequestHeader("cache-control", "no-cache");
xhr.setRequestHeader("postman-token", "72bb4b45-add1-aba4-c7ee-0b73c4f62edd");
console.log(data);

xhr.send(data);
 */


/* var settings = {
    "async": true,
    "crossDomain": true,
    "url": oauthRequest.base_string,
    "method": "GET",
    "headers": {
      "cache-control": "no-cache"
      //,"postman-token": "e6854631-a02f-9ace-f063-05a0c2602303"
    },
    "processData": false,
    "contentType": false,
    "mimeType": "multipart/form-data",
    "data": form
  } */
  
 /*  $.ajax(settings).done(function (response) {
    console.log(response);
  }); */

 