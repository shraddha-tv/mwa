<template>
  <v-dialog v-model="dialog" width="800px" persistent scrollable>
    <v-card>
      <v-card-title class="blue white--text">
        <v-layout justify-space-between>
          <v-flex>Create User</v-flex>
          <v-btn icon @click="close">
            <v-icon color="white">close</v-icon>
          </v-btn>
        </v-layout>
      </v-card-title>
      <v-card-text>
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-row class="mx-2">
            <v-col class="align-center justify-space-between" cols="12">
              <v-text-field label="Name" v-model="user.name" :rules="rules" />
            </v-col>
            <v-col cols="6">
              <v-text-field label="NIC" v-model="user.nic" />
            </v-col>
            <v-col cols="6">
              <v-text-field label="Email" v-model="user.email" />
            </v-col>
            <v-col cols="12">
              <v-text-field label="Mobile" v-model="user.mobile" />
            </v-col>
            <v-col cols="6">
              <v-select label="Type" v-model="user.type" :items="types" />
            </v-col>
            <v-col cols="6">
              <v-select
                label="State"
                v-model="user.state_id"
                :items="asserts.state"
                item-value="id"
                item-text="name"
              />
            </v-col>
            <v-col cols="12">
              <v-text-field label="Address" v-model="user.location.address" />
            </v-col>
            <v-col cols="12">
              <v-text-field label="District" v-model="user.location.district" />
            </v-col>
            <v-col cols="12">
              <v-text-field label="Provice" v-model="user.location.provice" />
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
    user: {
      name: "",
      nic: "",
      email: "",
      mobile: "",
      state_id: "",
      location: {
        address: "",
        district: "",
        provice: "",
        grama_niladari: "",
        division: ""
      },
      type: ""
    },
    rules: [v => !!v || "This Field is required"],
    types: ["farmers", "officers", "admin"]
  }),
  watch: {
    dialog(val) {
      val && this.Change();
    }
  },
  computed: {
    ...mapGetters({
      dialog: "user/getDialog",
      editItem: "user/getEditItem",
      asserts: "user/getAsserts"
    })
  },
  methods: {
    ...mapActions({
      setDialog: "user/set_dialog_form",
      addNewUser: "user/add_new_user",
      updateUser: "user/update_user",
      setEditItem: "user/set_edit_item",
      getAsserts: "user/get_asserts"
    }),
    Change() {
      this.getAsserts();
      if (this.editItem.id) {
        Object.assign(this.user, this.editItem);
      }
    },
    save() {
      if (this.$refs.form.validate()) {
        if (this.editItem.id) {
          this.updateItem(this.user);
        } else {
          this.addNewItem(this.user);
        }
      }
    },
    addNewItem(item) {
      this.addNewUser(item);
      this.close();
    },
    updateItem(item) {
      this.updateUser(item);
      this.close();
    },
    close() {
      (this.user = {
        name: "",
        nic: "",
        email: "",
        mobile: "",
        state_id: "",
        type: "",
        location: {
          address: "",
          district: "",
          provice: "",
          grama_niladari: "",
          division: ""
        }
      }),
        this.setEditItem(this.user);
      this.setDialog();
      this.$refs.form.resetValidation();
    }
  }
};
</script>