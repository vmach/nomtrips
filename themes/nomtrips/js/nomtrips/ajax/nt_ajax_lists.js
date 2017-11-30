var $ = jQuery;
$(document).ready(function() {

  $("#nomlistCitySelect").change(function(){
    var data = {
      city: $(this).val(),
      user: wpApiSettings.current_user_id
    };
    $.ajax({
      dataType: "json",
      url: wpApiSettings.root + 'nomtrips/nomlist/city/'+data.city+'/user/'+data.user,
      beforeSend: function ( xhr ) {
        xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
      },
      success: function(response){
        console.log(response);
        showNomLists(response);
      },
      fail: function(response){
        //console.log(wpApiSettings.failure);
        console.log(response);
      }
    });
  });
});

function showNomLists(items){
  //loops through each restaurant and does an api call to get restaurant

  items.restaurant_list.forEach(function(item) {
    $.ajax({
      dataType: "json",
      url: wpApiSettings.root + 'wp/v2/restaurant-api/'+item.RestaurantID,
      beforeSend: function ( xhr ) {
        xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
      },
      success: function(response) {
        var city = false;
        if(response.city.length > 0) {
          getCityById(response.city[0], response);
        }

      },
      fail: function(response){
        console.log(wpApiSettings.failure);
        console.log(response);
      }
    });
  });

}

function showRestaurant(city, restaurant) {

  console.log(city);
  console.log(restaurant);
  var itemsHtml = '';
    itemsHtml += '<div class="card--list-select--item">';
    itemsHtml += '<div class="card--list-select--title">' + restaurant.title.rendered + '</div>';
    itemsHtml += '<div class="card--list-select--address">' + restaurant.nt_cpt_street +', ' + city.name;
    itemsHtml += '</div><!--/card--list-select--address-->';
    itemsHtml += '</div><!--/card--list-select--item-->';
    $("#nomlistItems").append(itemsHtml);
}

function getCityById(city_id, restaurant) {
  $.ajax({
    dataType: "json",
    url: wpApiSettings.root + 'wp/v2/city/'+city_id,
    beforeSend: function ( xhr ) {
        xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
      },
    success: function(response) {
      showRestaurant(response, restaurant)
    },
    fail: function(response){
      console.log(wpApiSettings.failure);
      console.log(response);
    }
  });
}