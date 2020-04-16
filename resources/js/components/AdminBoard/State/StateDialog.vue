<template>
  <v-dialog v-model="dialog" width="500px" persistent scrollable>
    <v-card>
      <v-card-title class="blue white--text">
        <v-layout justify-space-between>
          <v-flex>Create New Item</v-flex>
          <v-btn icon @click="close">
            <v-icon color="white">close</v-icon>
          </v-btn>
        </v-layout>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-row class="mx-2">
            <v-col class="align-center justify-space-between" cols="12">
              <v-text-field label="Name" v-model="item.name" :rules="rules" />
            </v-col>
            <v-col cols="12">
              <v-text-field label="State" v-model="item.state" />
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-btn text color="primary">More</v-btn>
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
      name: "",
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
      dialog: "states/getDialog",
      editItem: "states/getEditItem"
    })
  },
  methods: {
    ...mapActions({
      setDialog: "states/set_dialog_form",
      addNewItem: "states/add_new_item",
      updateItem: "states/update_item",
      setEditItem: "states/set_edit_item"
    }),
    Change() {
      if (this.editItem.id) {
        Object.assign(this.item, this.editItem);
      }
    },
    save() {
      if (this.$refs.form.validate()) {
        if (this.editItem.id) {
          this.updateItem(this.item).then(responce =>{
            this.close()
          },error=>{

          });
        } else {
          this.addNewItem(this.item).then(
            responce=>{
              this.close()
            }
          );
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
        name: "",
      }),
        this.setEditItem(this.item);
      this.setDialog();
      this.$refs.form.resetValidation();
    }
  }
};
</script>