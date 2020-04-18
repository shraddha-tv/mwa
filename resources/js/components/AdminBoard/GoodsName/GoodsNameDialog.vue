<template>
  <v-dialog v-model="dialog" width="500px" persistent scrollable>
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
          <v-layout wrap pt-3>
            <v-flex xs12>
              <v-text-field label="Name in Sinhala" v-model="item.name_sin" :rules="rules" />
            </v-flex>
            <v-flex xs12>
              <v-text-field label="Name in English" v-model="item.name_eng"/>
            </v-flex>
            <v-flex xs12>
              <v-text-field label="Name in Singlish" v-model="item.name" :rules="rules"/>
            </v-flex>
            <v-flex xs12 v-if="item.id">
              <v-text-field label="State" v-model="item.state" />
            </v-flex>
          </v-layout>
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
    item: {
      id: "",
      name: "",
      name_eng: "",
      name_sin: ""
    },
    rules: [v => !!v || "This Field is required"]
  }),
  watch: {
    dialog(val) {
      val && this.Change();
    }
  },
  computed: {
    ...mapGetters({
      dialog: "goods_name/getDialog",
      editItem: "goods_name/getEditItem"
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
      setDialog: "goods_name/set_dialog_form",
      addNewItem: "goods_name/add_new_item",
      updateItem: "goods_name/update_item",
      setEditItem: "goods_name/set_edit_item"
    }),
    Change() {
      if (this.editItem.id) {
        Object.assign(this.item, this.editItem);
      }
    },
    save() {
      if (this.$refs.form.validate()) {
        if (this.editItem.id) {
          this.updateItem(this.item).then(
            responce => {
              this.close();
            },
            error => {}
          );
        } else {
          this.addNewItem(this.item).then(responce => {
            this.close();
          });
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
      this.setDialog();
      (this.item = {
        id: "",
        name: "",
        name_eng: "",
        name_sin: ""
      }),
        this.setEditItem(this.item);
      this.$refs.form.resetValidation();
    }
  }
};
</script>