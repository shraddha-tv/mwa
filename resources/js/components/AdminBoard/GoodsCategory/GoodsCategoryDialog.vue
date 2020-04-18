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
              <v-text-field label="Name" v-model="item.name" :rules="rules" />
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
      name: ""
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
      dialog: "category/getDialog",
      editItem: "category/getEditItem"
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
      setDialog: "category/set_dialog_form",
      addNewItem: "category/add_new_item",
      updateItem: "category/update_item",
      setEditItem: "category/set_edit_item"
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
      (this.item = {
        id: "",
        name: ""
      }),
        this.setEditItem(this.item);
      this.setDialog();
      this.$refs.form.resetValidation();
    }
  }
};
</script>