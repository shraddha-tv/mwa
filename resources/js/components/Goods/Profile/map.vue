<template>
  <v-layout>
    <!-- <div> -->
    <!-- <h2>Search and add a pin</h2> -->
    <!-- <label>
        <gmap-autocomplete
          @place_changed="setPlace">
        </gmap-autocomplete>
        <button @click="addMarker">Add</button>
    </label>-->
    <!-- <br/> -->

    <!-- </div> -->
    <br />
    <gmap-map
      :center="center"
      :zoom="12"
      style="width: 600px; height: 300px"
      :options="{
        fullscreenControl: true,
      }"
    >
      <gmap-marker
        :key="index"
        v-for="(m, index) in markers"
        :position="m.position"
        @click="center=m.position"
      ></gmap-marker>
    </gmap-map>
  </v-layout>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
  name: "GoogleMap",
  prop:["latitude","longitude"],
  data() {
    return {
      // default to Montreal to keep it simple
      // change this to whatever makes sense
      markers: [],
      places: [],
      currentPlace: null
    };
  },
  computed:{
    ...mapGetters({
      profile: "goods/getProfile"
    }),
    center(){
      const marker = {
        lat: parseFloat(this.profile.farmer.location.latitude),
          lng: parseFloat(this.profile.farmer.location.longitude)
        };
      this.markers.push({ position: marker });
      return marker;
    }
  },
  mounted() {
    this.geolocate();
  },

  methods: {
    // receives a place object via the autocomplete component
    setPlace(place) {
      this.currentPlace = place;
    },
    addMarker() {
      if (this.currentPlace) {
        // const marker = {
        //   lat: this.currentPlace.geometry.location.lat(),
        //   lng: this.currentPlace.geometry.location.lng()
        // };
        const marker = {
          lat: this.coordinate.latitude,
          lng: this.coordinate.longitude
        };
        this.markers.push({ position: marker });
        this.places.push(this.currentPlace);
        this.currentPlace = marker;
      }
    },
    geolocate: function() {
      // navigator.geolocation.getCurrentPosition(position => {
      //   this.center = {
      //     lat: position.coords.latitude,
      //     lng: position.coords.longitude
      //   };
      // });
      const marker = {
        lat: parseFloat(this.profile.farmer.location.latitude),
          lng: parseFloat(this.profile.farmer.location.longitude)
        };
      this.markers.push({ position: marker });
    }
  }
};
</script>