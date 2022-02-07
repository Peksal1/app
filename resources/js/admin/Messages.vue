<template>

<div class="container-fuiled">
     <AdminNavbar />
<Page :total="100" />
    <v-row class="p-5">
      <v-card
        v-for="message in messages"
        v-bind:key="message.id"
        class="mx-auto"
      >
     <Page :total="5"/>

        <v-card-title>
          {{ message.name }}
        </v-card-title>
 <v-card-title>
          {{ message.Email }}
        </v-card-title>
         <v-card-title>
          {{ message.message }}
        </v-card-title>
        <v-card-actions>
   <div>
        <b-button class="mod" @click="$bvModal.show('bv-modal-example')"
          >Delete<v-icon large color="teal darken-2"> mdi-delete </v-icon></b-button
        >
        <b-modal id="bv-modal-example" hide-footer>
          <template #modal-title> Delete message </template>
          <div class="d-block text-center">
            <h3>
              Do you want to delete this {{ message.message }} message?
            </h3>
          </div>
          <b-button
            class="btn btn-primary mt-3"
            block
            @click="$bvModal.hide('bv-modal-example')"
            >Cancel</b-button
          >
          <b-button
            class="btn btn-danger mt-3"
            block
            @click="deleteMessage(message.id)"
            >delete</b-button
          >
        </b-modal>
      </div>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
     
    </v-row>
  </div>

</template>

<script>
import axios from "axios";
import AdminNavbar from '../components/AdminNavbar.vue';
export default {
  data: function () {
    return {
      messages:[],
       isLoggedIn: false, 
       token: localStorage.getItem("token"),
    };
  },
      components:{
    AdminNavbar,
    },
  methods: {
    loadUsers() {
      axios.get("/api/messages",{
  headers: {
         Authorization: "Bearer " + this.token,
       }

      }).then(({ data }) => (this.messages = data.data));
       this.isLoggedIn= false
      console.log(this.messages)
    },
    deleteMessage(id) {
      axios
        .delete("/api/messages/" + id, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          console.log(response);
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "The message was deleted successfully!",
            showConfirmButton: false,
            timer: 1500,
          });
          this.$router.push("/messages");
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  
  created() {
    this.loadUsers();
    this.isLoggedIn= false
  },

};
</script>

<style>
</style>