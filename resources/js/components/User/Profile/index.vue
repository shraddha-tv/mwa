<template>
  <v-card>
    {{profile}}
  </v-card>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
export default {

  created() {
    this.getProfile(this.$route.params.id).then(
      response => {
      },
      error => {
        console.log("Bill subscription Not Found");
      }
    );
  },
  computed:{
    ...mapGetters({
      profile :'user/getProfile'
    })
  },
  methods:{
    ...mapActions({
      getProfile:'user/get_farmer_profile'
    })
  }
}
</script>