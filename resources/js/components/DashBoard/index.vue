<template>
   <v-container>
    <v-layout wrap>
      <v-spacer></v-spacer>
      <v-flex xs12 md6 v-if="!advanced">
        <v-autocomplete label="Search" prepend-icon="search" hide-no-data :search-input.sync="search" @keyup="searching" v-model="name"></v-autocomplete>
      </v-flex>
      <v-layout wrap justify-space-around v-else>
        <v-flex xs12 md4 px-1>
        <v-text-field label="Goods Name" prepend-icon="search" v-model="item.name" @keyup="AdvancedSearch"/>
        </v-flex>
        <v-flex xs12 md4 px-1>
        <v-text-field label="District" prepend-icon="search" v-model="item.district" @keyup="AdvancedSearch"/>
        </v-flex>
        <v-flex xs12 md4 px-1>
        <v-text-field label="GS Division" prepend-icon="search" v-model="item.gs_division" @keyup="AdvancedSearch"/>
        </v-flex>
      </v-layout>
      <v-flex xs12 md1 py-4>
        <v-btn text small @click="advanced = !advanced">{{advanced ? "hide" : "show" }} advanced</v-btn>
      </v-flex>
      <v-spacer></v-spacer>
    </v-layout>
    <v-layout wrap row>
      <template v-for="item in items.data">
        <v-flex xs12 md3 :key="item.id" pa-3>
          <v-card elevation=5>
            <v-card-text>
              <v-layout>
                <v-flex xs8 class="display-2 font-weight-black">{{item.name}}</v-flex>
                <v-flex xs4 class="text-center">
                  <v-flex class="display-1">{{item.price}} /=</v-flex>
                  <v-flex class="title">1 {{item.unit_price}}</v-flex>
                </v-flex>
              </v-layout>
              <v-divider></v-divider>

              <v-layout py-5 wrap>
                    <v-flex xs12 class="text-end title">{{item.available_amount}} {{item.unit_price}}</v-flex>
                    <v-flex xs12
                      v-if="item.location"
                    >{{item.location.address}}, {{item.location.district}}</v-flex>
                  </v-layout>

              <!-- <v-layout py-5 wrap>
                <v-flex v-if="item.location">
                  {{item.location.address}},  {{item.location.district}}
                </v-flex>
                <v-flex class="text-end title">
                {{item.available_amount}} {{item.unit_price}}
                </v-flex>
              </v-layout> -->

              <v-btn block text class="success" @click="viewItem(item.id)">View</v-btn>
            </v-card-text>
          </v-card>
        </v-flex>
      </template>
    </v-layout>
  </v-container>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
export default {
  data: () => ({
    advanced:true,
    name:'',
    search:'',
    item :{
      name :'',
      district:'',
      gs_division:''
    }
  }),
  created(){
    this.searchItem()
  },
  computed:{
    ...mapGetters({
      items : 'goods/getItems'
    })
  },
  methods:{
    ...mapActions({
      searchItem : 'goods/item_search',
      advancedSearchItem : 'goods/item_advanced_search'
    }),
    searching(){
      this.searchItem(this.search)
    },
    AdvancedSearch(){
      this.advancedSearchItem(this.item)
    },
    viewItem(id){
      this.$router.push({ path: `/goods/${id}` });
    }
  }
};
</script>