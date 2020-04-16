<template>
  <v-card class="ma-3">
    <v-card-title class="blue white--text">
      <v-layout justify-space-between>
        <v-flex>State Table</v-flex>
        <v-spacer></v-spacer>
        <v-flex xs1>
          <v-btn @click="openDialog">
            <v-icon>add</v-icon>
            <span>ADD NEW</span>
          </v-btn>
        </v-flex>
      </v-layout>
    </v-card-title>
    <v-card-text>
      <v-data-table :items="allData.data" :headers="headers" hide-default-footer>
        <template v-slot:item.action = {item}>
          <v-layout>
            <v-btn icon>
              <v-icon>visibility</v-icon>
            </v-btn>
            <v-btn icon @click="editItem(item)">
              <v-icon>edit</v-icon>
            </v-btn>
            <v-btn icon>
              <v-icon>delete</v-icon>
            </v-btn>
          </v-layout>
        </template>
      </v-data-table>
       <!--===============================================================================================->
                                       Custom Pagination of Data Table
        <--===============================================================================================-->
        <div class="text-xs-center pt-2 grey lighten-2">
          <v-layout>
            <v-flex xs2></v-flex>
            <v-flex xs6>
              <v-pagination v-model="page" :length="pages" :total-visible="7" color="grey darken-2"></v-pagination>
            </v-flex>
            <v-flex xs4 layout>
              <v-subheader
                v-if="allData.data"
              >1-{{ allData.data.length }} of {{ allData.data.length }}</v-subheader>
              <v-subheader>Rows per page 15</v-subheader>
            </v-flex>
          </v-layout>
        </div>
    </v-card-text>
  </v-card>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data: () => ({
    page: 1,
    headers: [
      { text: "ID", value: "id" },
      { text: "NAME", value: "name" },
      { text: "STATE", value: "state" },
      { text: "ACTION", value: "action", width:'1%',sortable:false },
    ]
  }),
  created() {
    this.getAllItems();
  },
  watch: {
    dialog(val) {
      val || this.getAllItems();
    },
     page(val) {
      this.loader();
      this.getAllItems(this.page).then(result => {
        this.loader();
      });
    },
  },
  computed: {
    ...mapGetters({
      allData: "states/getItems",
      dialog: "states/getDialog",
    }),
    pages() {
      if (this.allData.data)
        return Math.ceil(this.allData.data.length / 15);
    },
  },
  methods: {
    ...mapActions({
      getAllItems: "states/get_items",
      setDialog: "states/set_dialog_form",
      setEditItem: "states/set_edit_item",
      deleteItem: "states/delete_item"
    }),
    openDialog() {
      this.setDialog();
    },
    editItem(item){
      this.setDialog()
      this.setEditItem(item)
    },
    deleteItem(){
      confirm('Are you sure you want to delete this item?') && this.deleteItem()
    }
  }
};
</script>