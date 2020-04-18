<template>
  <div>
    <v-layout>
      <v-btn text color="warning" @click="goHome()">
        <v-icon class="pr-2">home</v-icon>Home
      </v-btn>
    </v-layout>
    <v-container>
      <v-layout justify-space-around wrap>
        <!-- ---------------------------------------------------------------------------------------------------------
                              Goods Details
        -------------------------------------------------------------------------------------------------------------->
        <v-flex xs12 md4 px-3>
          <v-card v-if="profile.goods">
            <v-card-title>
              <v-layout>
                <v-flex xs8 class="display-2 font-weight-black">{{profile.goods.name}}</v-flex>
                <v-flex xs4 class="text-center">
                  <v-flex class="display-1">{{profile.goods.price}} /=</v-flex>
                  <v-flex class="title">1 {{profile.goods.unit_price}}</v-flex>
                </v-flex>
              </v-layout>
            </v-card-title>
            <v-card-text>
              <v-layout justify-center class="body-1">
                Available Amount :
                <span
                  class="font-weight-black"
                >{{profile.goods.available_amount}} {{profile.goods.unit_price}}</span>
              </v-layout>
              <v-row>
                <v-col>
                  <v-flex class="font-weight-black">
                    <v-icon small>person</v-icon>
                    {{profile.farmer.name}}
                  </v-flex>
                  <v-flex v-for="item in profile.farmer.contact" :key="item">
                    <v-icon small>phone</v-icon>
                    {{item}}
                  </v-flex>
                  <v-flex>
                    <v-icon small>alternate_email</v-icon>
                    {{profile.farmer.email || '-'}}
                  </v-flex>
                </v-col>
                <v-col>
                  <v-flex>
                    <v-icon small>place</v-icon>
                    {{profile.farmer.location.address}}
                  </v-flex>
                  <v-flex>
                    <v-icon small>place</v-icon>
                    {{profile.farmer.location.gs_division}}
                  </v-flex>
                  <v-flex>
                    <v-icon small>place</v-icon>
                    {{profile.farmer.location.district}} District
                  </v-flex>
                  <v-flex>
                    <v-icon small>place</v-icon>
                    {{profile.farmer.location.province}} Province
                  </v-flex>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
          <v-layout>
            <google-map />
          </v-layout>
        </v-flex>
        <v-spacer></v-spacer>
        <!-- ---------------------------------------------------------------------------------------------------------
                              Farmer Others
        -------------------------------------------------------------------------------------------------------------->
        <v-flex xs12 md6>
          <v-divider></v-divider>
          <v-layout class="title">Farmer Other Goods</v-layout>
          <v-divider></v-divider>
          <v-layout wrap>
            <v-flex xs12 md4 pa-3 v-for="item in profile.farmer_rel" :key="item.id">
              <v-card>
                <v-card-title>
                  <v-layout>
                    <v-flex xs8 class="display-1">{{item.name}}</v-flex>
                    <v-flex xs4 class="text-center">
                      <v-flex>{{item.price}} /=</v-flex>
                      <v-flex>1 {{item.unit_price}}</v-flex>
                    </v-flex>
                  </v-layout>
                </v-card-title>
                <v-card-text>
                  <v-layout py-2 wrap>
                    <v-flex xs12 class="text-end">{{item.available_amount}} {{item.unit_price}}</v-flex>
                    <v-flex xs12
                      v-if="item.location"
                    >{{item.location.address}}, {{item.location.district}}</v-flex>
                  </v-layout>
                </v-card-text>
                <v-card-actions>
                  <v-btn block text class="success" @click="viewItem(item.id)">View</v-btn>
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-layout>

          <v-divider></v-divider>

        <!-- ---------------------------------------------------------------------------------------------------------
                              Goods Others
        -------------------------------------------------------------------------------------------------------------->
          <v-layout class="title">Other Relational Goods</v-layout>
          <v-divider></v-divider>
          <v-layout wrap>
            <v-flex xs12 md4 pa-3 v-for="item in profile.goods_rel" :key="item.id">
              <v-card>
                <v-card-title>
                  <v-layout>
                    <v-flex xs8 class="display-1">{{item.name}}</v-flex>
                    <v-flex xs4 class="text-center">
                      <v-flex>{{item.price}} /=</v-flex>
                      <v-flex>1 {{item.unit_price}}</v-flex>
                    </v-flex>
                  </v-layout>
                </v-card-title>
                <v-card-text>
                  <v-layout py-2 wrap>
                    <v-flex xs12 class="text-end">{{item.available_amount}} {{item.unit_price}}</v-flex>
                    <v-flex xs12
                      v-if="item.location"
                    >{{item.location.address}}, {{item.location.district}}</v-flex>
                  </v-layout>
                </v-card-text>
                <v-card-actions>
                  <v-btn block text class="success" @click="viewItem(item.id)">View</v-btn>
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-container>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import GoogleMap from "./map";
export default {
  created() {
    this.getProfile(this.$route.params.id).then(
      response => {},
      error => {
        console.log("Bill subscription Not Found");
      }
    );
  },
  components: {
    GoogleMap
  },
  computed: {
    ...mapGetters({
      profile: "goods/getProfile"
    })
  },
  methods: {
    ...mapActions({
      getProfile: "goods/get_goods_profile"
    }),
    viewItem(id) {
      this.getProfile(id);
      this.$router.push({ path: `/goods/${id}` });
    },
    goHome() {
      console.log("kk");
      this.$router.push({ path: "/" });
    }
  }
};
</script>