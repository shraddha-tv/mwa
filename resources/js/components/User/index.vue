<template>
  <v-card>
    User
  </v-card>
</template>

<script>
import {mapActions} from 'vuex';
export default {
  created(){
    this.getUsers()
  },
  methods:{
    ...mapActions({
      getUsers : "user/get_users"
    })
  }
}
</script>

