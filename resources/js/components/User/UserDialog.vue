<template>
  <v-dialog v-model="dialog" width="1200px" persistent scrollable>
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
          <v-row class="justify-space-between mx-1">
            <v-col cols="6">
              <v-row>
                <v-text-field label="Name" v-model="user.name" :rules="rules" @keyup="getGeoLoaction()" />
              </v-row>
              <v-row>
                <v-col cols="6">
                  <v-text-field label="NIC" v-model="user.nic" />
                </v-col>
                <v-col cols="6">
                  <v-text-field label="Email" v-model="user.email" />
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="6">
                  <v-select label="Type" v-model="user.type" :items="types" />
                </v-col>
                <v-col cols="6" v-if="user.id">
                  <v-select
                    label="State"
                    v-model="user.state_id"
                    :items="asserts.state"
                    item-value="id"
                    item-text="name"
                  />
                </v-col>
              </v-row>
              <v-row v-for="item in user.contact" :key="item">
                <v-col cols="11">
                  <v-text-field label="Contact" :value="item" />
                </v-col>
                <v-col cols="1">
                  <v-btn icon @click="removeContact(item)">
                    <v-icon>delete</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="11">
                  <v-text-field label="Contact" v-model="mobile" />
                </v-col>
                <v-col cols="1">
                  <v-btn icon @click="addContact">
                    <v-icon>add</v-icon>
                  </v-btn>
                </v-col>
              </v-row>
            </v-col>

            <!-- Right side -->
            <v-col cols="5">
              <v-row>
                <v-text-field label="Address" v-model="user.location.address" />
              </v-row>
              <v-row>
                <v-col cols="6">
                  <v-select label="Province" v-model="user.location.province" :items="province" />
                </v-col>
                <v-col cols="6">
                  <v-select
                    label="District"
                    v-model="user.location.district"
                    :items="selectDistrict"
                  />
                </v-col>
              </v-row>
              <v-row>
                <v-col cols="6">
                  <v-text-field label="GS Division" v-model="user.location.gs_division" />
                </v-col>
                <v-col cols="6">
                  <v-text-field
                    label="Divisional Secretariat"
                    v-model="user.location.divisional_secretariat"
                  />
                </v-col>
              </v-row>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
      <v-card-actions>
        {{location}}
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
    location: "",
    mobile: "",
    user: {
      id: "",
      name: "",
      nic: "",
      email: "",
      contact: [],
      state_id: "",
      type: "",
      location: {
        address: "",
        gs_division: "",
        divisional_secretariat: "",
        district: "",
        province: "",
        latitude: "",
        longitude: ""
      }
    },
    rules: [v => !!v || "This Field is required"],
    types: ["farmers", "officers", "admin"],
    district: {
      Northern: ["Jaffna", "Kilinochchi", "Mannar", "Mullaitivu", "Vavuniya"],
      "North Western": ["Puttalam", "Kurunegala"],
      Western: ["Gampaha", "Colombo", "Kalutara"],
      "North Central": ["Anuradhapura", "Polonnaruwa"],
      Central: ["Matale", "Kandy", "Nuwara Eliya"],
      Sabaragamuwa: ["Kegalle", "Ratnapura"],
      Eastern: ["Trincomalee", "Batticaloa", "Ampara"],
      Uva: ["Badulla", "Monaragala"],
      Southern: ["Hambantota", "Matara", "Galle"]
    },
    province: [
      "Northern",
      "North Western",
      "Western",
      "North Central",
      "Central",
      "Sabaragamuwa",
      "Eastern",
      "Uva",
      "Southern"
    ]
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
    }),
    selectDistrict() {
      var province = this.user.location.province;
      return this.district[province];
    },
    titleName() {
      return this.user.id ? "Update" : "Add New";
    },
    titleColor() {
      return this.user.id ? "grey" : "primary";
    }
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
        if (this.mobile) {
          this.addContact();
        }
        if (this.editItem.id) {
          this.updateItem(this.user);
        } else {
          this.addNewItem(this.user);
        }
      }
    },
    addNewItem(item) {
      this.addNewUser(item).then(respnce => this.close());
    },
    updateItem(item) {
      this.updateUser(item).then(respnce => this.close());
    },
    close() {
      (this.user = {
        id: "",
        name: "",
        nic: "",
        email: "",
        contact: [],
        state_id: "",
        type: "",
        location: {
          address: "",
          gs_division: "",
          divisional_secretariat: "",
          district: "",
          province: "",
          latitude: "",
          longitude: ""
        }
      }),
        this.setEditItem(this.user);
      this.setDialog();
      this.$refs.form.resetValidation();
    },
    addContact() {
      this.user.contact.push(this.mobile);
      this.mobile = "";
    },
    removeContact(item) {
      const index = this.user.contact.indexOf(item);
      this.user.contact.splice(index, 1);
    },
    getGeoLoaction() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
          this.location = "ok"
          this.user.location.latitude = pos.coords.latitude
          this.user.location.longitude = pos.coords.longitude
        });
      } else {
        this.location = "Geolocation is not supported by this browser.";
      }
    }
  }
};
</script>