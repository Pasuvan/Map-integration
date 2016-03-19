

<input type="hidden" id="location" value='{"1":{"tracking_id":"2fa879ce0f0ad12e166da7fa6d76391b","start_lat":"9.9252007","start_lng":"78.11977539999998","end_lat":"10.3673123","end_lng":"77.98029059999999"},"2":{"tracking_id":"c05700ca73bf18048b9d996d3ea74a39","start_lat":"9.9252007","start_lng":"78.11977539999998","end_lat":"10.3673123","end_lng":"77.98029059999999"},"3":{"tracking_id":"ea7f7ed83715aadf6b4c4edef30e39ea","start_lat":"13.0102357","start_lng":"80.21565099999998","end_lat":"13.0405026","end_lng":"80.2336924"},"4":{"tracking_id":"890ad199ec202fffe2105ca8a13c1f89","start_lat":"13.0102357","start_lng":"80.21565099999998","end_lat":"13.0405026","end_lng":"80.2336924"}}'/>
<input type="hidden" id="waypoint" value='{"2fa879ce0f0ad12e166da7fa6d76391b":[{"lat":"9.9252007","lng":"78.11977539999998"}],"c05700ca73bf18048b9d996d3ea74a39":{"1":{"lat":"9.9252007","lng":"78.11977539999998"}},"ea7f7ed83715aadf6b4c4edef30e39ea":{"2":{"lat":"13.0102357","lng":"80.21565099999998"}},"890ad199ec202fffe2105ca8a13c1f89":{"3":{"lat":"13.0102357","lng":"80.21565099999998"}}}'/>
<input type="hidden" id="marker" value='{"2fa879ce0f0ad12e166da7fa6d76391b":[{"lat":"9.9252007","lng":"78.11977539999998","image":"map.png","username":"raj","mobile":"9025940064"}],"c05700ca73bf18048b9d996d3ea74a39":{"1":{"lat":"9.9252007","lng":"78.11977539999998","image":"map.png","username":"raj","mobile":"9025940064"}},"ea7f7ed83715aadf6b4c4edef30e39ea":{"2":{"lat":"13.0102357","lng":"80.21565099999998","image":"map.png","username":"mtuh","mobile":"9025942354"}},"890ad199ec202fffe2105ca8a13c1f89":{"3":{"lat":"13.0102357","lng":"80.21565099999998","image":"map.png","username":"mtuh","mobile":"9025942354"}}}'/>

 <div id="map" style="width: 1200px; height: 600px;"></div>

    </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?libraries=places"></script>
            <script>

            var map;
            var waypoints;
            var markerpoint;
            var locations1;
            
            function initialize() {
			     
	             if($('#location').val()!=''){
	            	 locations1   = JSON.parse( $('#location').val());
	             }
                if($('#waypoint').val()!=''){
                  waypoints    = JSON.parse($('#waypoint').val());
                }
                if($('#marker').val()!=''){
                  markerpoint    =   JSON.parse($('#marker').val());
                }
                         
              directionsDisplay = new google.maps.DirectionsRenderer({
                    suppressMarkers: true
            //          polylineOptions: polylineOptionsActual
              });
              
             
              var bangalore = { lat: 11.652236, lng: 78.793945 };
              var mapOptions = {
                zoom:8,
                center: bangalore
              };
              map = new google.maps.Map(document.getElementById('map'), mapOptions);
              directionsDisplay.setMap(map);
              
        var infoWindow = new google.maps.InfoWindow();
        
                var lat_lng = new Array();
                var latlngbounds = new google.maps.LatLngBounds();
         var baseurl  =   $('#baseurl').val();
                //Initialize the Path Array
             var path = new google.maps.MVCArray();
         
              var i=0;
                directionsServices = [];
                directionsDisplays = [];
                if(locations1!='' && locations1!=undefined){
	                $.each(locations1, function(key, location){
                         
	                  directionsServices[i] = new google.maps.DirectionsService();
	                  var start = new google.maps.LatLng(location.start_lat, location.start_lng);
	                  var end = new google.maps.LatLng(location.end_lat, location.end_lng);
	                 
	                  var waypts = [];
	                  var path1 = [];
		               if(waypoints!='' && waypoints!=undefined){
		                  $.each(waypoints, function(way, value){
		                      if(way==location.tracking_id){
		                          $.each(value, function(key, point){
		                            if (point.lat!=undefined && point.lng!= undefined ){
		                            	var color	=	"yellow";
		                            	var colorWeight	=	3;
		                            	if (i % 2 == 0){
		                            		color	=	"green";
		                            		colorWeight	=	9;
		                            	}
		                                
			                                /** set waypoints  **/
			                                  stop = new google.maps.LatLng(point.lat, point.lng);
			                                  waypts.push({
			                                              location:stop,
			                                              stopover:true
			                                              });
                                              /** set marker point */
                                              
                                              if(markerpoint!='' && markerpoint!=undefined){
				                                  $.each(markerpoint, function(mar, marValue){
					                                    if(mar==location.tracking_id){
					                                    	//var iconPath= baseurl+'assets/ico/map'+i+'.png';
					                                        //console.log(baseurl+'assets/ico/map'+i+'.png');
					                                          $.each(marValue, function(key1, point1){  
					                                        	  
					                                        	  var myLatlng = new google.maps.LatLng(point1.lat, point1.lng);
					                                        	  lat_lng.push(myLatlng);
					                                        	  var geocoder	=   new google.maps.Geocoder();
					                                          	geocoder.geocode({
					                                                  'latLng': myLatlng
					                                              }, function(place, status) {
// 					                                        		    if (status === google.maps.GeocoderStatus.OK) {
																			var address = "unknown "+ myLatlng;
																			if(status === google.maps.GeocoderStatus.OK ){
																				address	=	 place[0].formatted_address;
																			}
																			
					                                        		      var marker = new google.maps.Marker({
					                                        		    	  position: myLatlng,
								                                              map: map,
								                                              icon: point1.image,
// 								                                              label: point1.name,
								                                              title: mar
					                                        		      });
					                                        		      
					                                        		      latlngbounds.extend(marker.position);
							                                                (function (marker, point1) {
							                                                    google.maps.event.addListener(marker, "click", function (e) {
							                                                    	 var text	= 'TrackingID:'+mar+'<br>Name: '+point1.username+'<br> Mobile: '+point1.mobile+'<br><div><strong> Place: ' +address; + '</strong><br>';
							                                                        infoWindow.setContent(text);
							                                                        infoWindow.open(map, marker);
							                                                    });
							                                                })(marker, point1);
							                                                map.setCenter(latlngbounds.getCenter());
							                                                map.fitBounds(latlngbounds);
							                                                
// 					                                        		    }
					                                        		  });

						                                          
					                                            /** set marker icon and title  **/
					                                            /*    var myLatlng = new google.maps.LatLng(point1.lat, point1.lng);
					                                                var address = findlocation( point1.lat, point1.lng );
					                                                console.log(address);
					                                                lat_lng.push(myLatlng);
					                                                var marker = new google.maps.Marker({
												                                                position: myLatlng,
												                                                map: map,
												                                                icon: point1.image,
												                                                title: mar
								                                              		  });
				                                              		  
					                                                latlngbounds.extend(marker.position);
					                                                (function (marker, point1) {
					                                                    google.maps.event.addListener(marker, "click", function (e) {
					                                                    	 var text	= 'Name: '+point1.username+'<br> Mobile: '+point1.mobile+'<br>Full address is: ' + marker.position;
					                                                        infoWindow.setContent(text);
					                                                        infoWindow.open(map, marker);
					                                                    });
					                                                })(marker, point1);
					                                                map.setCenter(latlngbounds.getCenter());
					                                                map.fitBounds(latlngbounds);*/
					                                        });
					                                     }
					                                 });
                                              }
				                                    /** set poly line  **/
				                                    path1.push(new google.maps.LatLng(point.lat, point.lng));
				                                    var poly = new google.maps.Polyline({ path:path1, map: map,strokeColor: color,strokeOpacity: 1.0,strokeWeight: colorWeight});
		                                }
		                            });
		
		                          }
		
		                      });
		                  }
	
	                  var request = {
	                              origin: start,
	                              destination: end,
	                              waypoints: [],
	                              optimizeWaypoints: true,
	                              travelMode: google.maps.TravelMode.DRIVING
	                          };
	                directionsServices[i].route(request, function(response, status) {
	                    if (status == google.maps.DirectionsStatus.OK) {
	                        directionsDisplays.push(new google.maps.DirectionsRenderer({preserveViewport:true}));
	                      directionsDisplays[directionsDisplays.length-1].setMap(map);
	                      directionsDisplays[directionsDisplays.length-1].setDirections(response);
	                    } else alert("Directions request failed:"+status);
	                 });
	                i++;
	                });
	             }
                
               }

	google.maps.event.addDomListener(window, 'load', initialize);
	</script>
	
