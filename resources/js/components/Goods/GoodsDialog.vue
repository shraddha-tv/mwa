<template>
  <v-dialog v-model="dialog" width="800px" persistent scrollable>
    <v-card>
      <v-card-title :class="`${titleColor} white--text`">
        <v-layout justify-space-between>
          <v-flex>{{titleName}} Item</v-flex>
          <v-btn icon @click="close">
            <v-icon color="white">close</v-icon>
          </v-btn>
        </v-layout>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-row class="mt-2">
            <v-col cols="6">
              <v-autocomplete
                label="Farmer Name"
                :search-input.sync="search"
                v-model="item.user_id"
                :rules="rules"
                :items="farmers.data"
                item-text="name"
                item-value="id"
                @keyup="userSearch"
              />
            </v-col>
            <v-col cols="6">
              <v-select
                label="Goods Name"
                v-model="item.name_id"
                :rules="rules"
                :items="asserts.name"
                item-text="name_sin"
                item-value="id"
              />
            </v-col>
            <v-col cols="6">
              <v-text-field prefix="Rs:" label="Price" v-model="item.price" type="number" />
            </v-col>
            <v-col cols="4">
              <v-text-field label="Available Amount" v-model="item.available_amount" type="number" />
            </v-col>
            <v-col cols="2">
              <v-select label="Unit" v-model="item.unit_price" :items="units" />
            </v-col>
            <v-col cols="6">
              <v-select
                label="Category"
                v-model="item.category_id"
                :items="asserts.category"
                item-text="name"
                item-value="id"
              />
            </v-col>
            <v-col cols="12" v-if="item.id">
              <v-text-field label="State" v-model="item.state" />
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn text color="primary" @click="close">Cancel</v-btn>
        <v-btn text @click="save">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data: () => ({
    valid: true,
    search: "",
    item: {
      id: "",
      user_id: "",
      name_id: "",
      price: "",
      available_amount: "",
      unit_price: ""
    },
    rules: [v => !!v || "This Field is required"],
    units:["Kg","පැකට්","ගෙඩි","පෙට්ටි","වෙනත්"]
  }),
  watch: {
    dialog(val) {
      val && this.Change();
    }
  },
  computed: {
    ...mapGetters({
      dialog: "goods/getDialog",
      farmers: "user/getUsers",
      editItem: "goods/getEditItem",
      asserts: "goods/getAsserts"
    }),
    titleName() {
      return this.item.id ? "Update" : "Add New";
    },
    titleColor() {
      return this.item.id ? "grey" : "primary";
    }
  },
  methods: {
    ...mapActions({
      setDialog: "goods/set_dialog_form",
      addNewItem: "goods/add_new_item",
      updateItem: "goods/update_item",
      setEditItem: "goods/set_edit_item",
      getAsserts: "goods/get_asserts",
      getFarmers: "user/get_farmers"
    }),
    Change() {
      this.getAsserts();
      if (this.editItem.id) {
        Object.assign(this.item, this.editItem);
      }
    },
    save() {
      if (this.$refs.form.validate()) {
        if (this.editItem.id) {
          this.updateItem(this.item).then(response => this.close());
        } else {
          this.addNewItem(this.item).then(responce => this.close());
        }
      }
    },
    // addNewItem(item) {
    //   this.addNewItem(item);
    //   this.close();
    // },
    // updateItem(item) {
    //   this.updateItem(item);
    //   this.close();
    // },
    close() {
      (this.item = {
        id: "",
        user_id: "",
        name_id: "",
        price: "",
        available_amount: "",
        unit_price: ""
      }),
        this.setEditItem(this.item);
      this.setDialog();
      this.$refs.form.resetValidation();
    },

    userSearch() {
      this.getFarmers(this.search);
    }
  }
};
</script>