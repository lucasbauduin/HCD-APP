<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #map {
        margin-bottom: 20px;
    }
    /* Optional: Makes the sample page fill the window. */
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }
</style>
<div class="row mx-0 h-100">
    <div id="intervention-details" class="row mx-0 col-2" style="height:0%;">
        
    </div>
    <div class="row mx-0 col-10">
        <div id="map" class="w-100"></div>
        <div id="planning" class="w-100" style="position: relative;">
            <div id="carouselPlanning" class="owl-carousel">
                <?php 
                for($i = 0; $i<30; $i++){ 
                    $date = date("l d M Y", mktime(0, 0, 0, date("m"), date("d")+$i, date("Y")));
                    echo '<div id="' . date("d-m-Y", mktime(0, 0, 0, date("m"), date("d")+$i, date("Y"))) . '">';
                    echo '<div class="row text-center">';
                    echo '<div class="col-12">'. $date . '</div>';
                    echo '</div>';
                    ?>
                    <div class="row text-center">
                        <div class="col-2">
                            Technicien
                        </div>
                        <div class="col-5">
                            Matin
                        </div>
                        <div class="col-5">
                            Après-midi
                        </div>
                    </div>
                <?php
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    var map;
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
<?php
echo 'center: {lat:' . $uneIntervention['latitude'] . ', lng:' . $uneIntervention['longitude'] . '},';
?>
            zoom: 12,
            streetViewControl: false,
            styles: [
                {
                    "featureType": "water",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#e9e9e9"
                        },
                        {
                            "lightness": 17
                        }
                    ]
                },
                {
                    "featureType": "landscape",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f5f5f5"
                        },
                        {
                            "lightness": 20
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 17
                        }
                    ]
                },
                {
                    "featureType": "road.highway",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 29
                        },
                        {
                            "weight": 0.2
                        }
                    ]
                },
                {
                    "featureType": "road.arterial",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 18
                        }
                    ]
                },
                {
                    "featureType": "road.local",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 16
                        }
                    ]
                },
                {
                    "featureType": "poi",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f5f5f5"
                        },
                        {
                            "lightness": 21
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#dedede"
                        },
                        {
                            "lightness": 21
                        }
                    ]
                },
                {
                    "elementType": "labels.text.stroke",
                    "stylers": [
                        {
                            "visibility": "on"
                        },
                        {
                            "color": "#ffffff"
                        },
                        {
                            "lightness": 16
                        }
                    ]
                },
                {
                    "elementType": "labels.text.fill",
                    "stylers": [
                        {
                            "saturation": 36
                        },
                        {
                            "color": "#333333"
                        },
                        {
                            "lightness": 40
                        }
                    ]
                },
                {
                    "elementType": "labels.icon",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "transit",
                    "elementType": "geometry",
                    "stylers": [
                        {
                            "color": "#f2f2f2"
                        },
                        {
                            "lightness": 19
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry.fill",
                    "stylers": [
                        {
                            "color": "#fefefe"
                        },
                        {
                            "lightness": 20
                        }
                    ]
                },
                {
                    "featureType": "administrative",
                    "elementType": "geometry.stroke",
                    "stylers": [
                        {
                            "color": "#fefefe"
                        },
                        {
                            "lightness": 17
                        },
                        {
                            "weight": 1.2
                        }
                    ]
                }
            ],
            mapTypeId: 'roadmap'
        });

        //récupération des adresses

        var features = [

<?php
getFeature($uneIntervention, "", "");
$i = 1;
foreach ($allInterventions as $inter) {
    if ($inter['id'] != $uneIntervention['id']) {
        getFeature($inter, $i, "all");
    }
    if ($inter['id'] != $uneIntervention['id'] && $i != count($allInterventions)) {
        echo ",";
    }
    $i++;
}
function getFeature($item, $i, $type){
    $color = array('SARL Ferret' => 'blue', 'SARL PROX C.E.S.' => 'green', 'Chauffage du Nord' => 'orange', '' => 'purple');
    $icon = "red";
    $open = "true";
    if ($type == "all"){
        $icon = $color[addslashes($item['company'])];
        $open = "false";
    }
    else {
        $i = "first";
    }
    echo  ' {position: new google.maps.LatLng(' . $item['latitude'] . ', ' . $item['longitude'] . '), '
        . ' type: "' . $icon . '", '
        . ' open : "' . $open . '", '
        . ' id : "' . $i . '", '
        . ' company : "' . addslashes($item['company']) . '", '
        . ' idIntervention : "' . addslashes($item['name']) . '", '
        . ' zip : "' . addslashes($item['zip']) . '", '
        . ' ville : "' . addslashes($item['ville']) . '", '
        . ' adresse : "' . addslashes($item['adresse']) . '", '
        . ' pays : "' . addslashes($item['pays']) . '", '
        . ' technicien : "' . addslashes($item['technicien']) . '", '
        . ' nom_client : "' . addslashes($item['nom_client']) . '"';
    if ($type == "all") {
        echo  ', hour_start : "' . addslashes($item['hour_start']) . '", '
            . ' hour_end : "' . addslashes($item['hour_end']) . '", '
            . ' date_start : "' . addslashes($item['date_start']) . '", '
            . ' date_end : "' . addslashes($item['date_end']) . '", '
            . '}';
    }
    else {
        echo '}, ';
    }
        
}
?>
        ]
        console.log(features);
        var markers = [];
        var techniciens = [];
        features.forEach(function (feature) {
            var marker = new google.maps.Marker({
                position: feature.position,
                title: feature.idIntervention,
                map: map,
                animation: google.maps.Animation.DROP
            });

            marker.set("id", feature.id)

            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });
            marker.setIcon('http://maps.google.com/mapfiles/ms/icons/' + feature.type + '-dot.png');


            var infowindow = new google.maps.InfoWindow({
                content: feature.idIntervention 
            });
            var divIntervention = '<div class="row mx-0 w-100 col-12 py-1 my-1"><div class="idIntervention col-12"><span>' + feature.idIntervention + '</span></div><div class="address col-12"><span>' + feature.adresse + '</span><br /><span>' + feature.zip + ' ';
            var endDivIntervention = feature.ville + '</span><br /><span>' + feature.pays + '</span></div></div>';
            $('#intervention-details').append(divIntervention + endDivIntervention);
            if (feature.open === "false" && feature.technicien !== "" && !techniciens.includes(feature.technicien + feature.date_start)){
                techniciens.push(feature.technicien + feature.date_start);
                var planningIntervention = '<div class="row text-center"><div class="col-2">' + feature.technicien + '</div><div class="col-5">' + feature.hour_start + '-' + feature.hour_end + '</div><div class="col-5"></div></div>';
                console.log(feature.date_start.replace('/', '-'));
                $("#" + feature.date_start).append(planningIntervention);
            }   
            markers.push(marker);
        });
    }
    $(".owl-carousel").owlCarousel({
            loop: false,
            items: 1,
            nav: true,
            mouseDrag: false,
            pullDrag: false,
            touchDrag: false,
            freeDrag: false,
        });
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCDoU8n0pz0q_hleBWtNt3xYOyEYhe54iQ&callback=initMap"
async defer></script>
