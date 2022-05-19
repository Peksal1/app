<template>
  <div class="container">
    <div class="
        new-stores-option
        d-flex
        justify-content-between
        align-items-center
      ">
      <div class="btn btn-sm btn-primary" @click="openCollectionModal">
        New collection
      </div>

    </div>
    <br />
    <router-link class="btn btn-sm btn-primary" style="color:white" :to="{ name: 'portfolio/admin' }">Manage the
      portfolio</router-link>
    <!-- modal vindow -->
    <div class="modal" :class="{ show: showCollectionModal }" id="collectionModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong>New collection</strong>
            </h5>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hideCollectionModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitCollectionForm">
              <div class="form-group">
                <label for="">Title</label>
                <input v-model="collectionForm.name" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Description</label>
                <input v-model="collectionForm.description" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">Start date: </label>
                <input v-model="collectionForm.start_date" type="month" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="">End date:</label>
                <input v-model="collectionForm.end_date" type="month" class="form-control" required />
              </div>
              <div class="p-2 w-full">
                <div class="relative">
                  <label for="attachment" class="leading-7 text-sm text-gray-600">Attachments</label><br />

                  <input type="file" accept="image/*" @change="uploadImage($event)" id="file-input" required />
                </div>
              </div>
              <div class="form-group">
                <input type="submit" value="Submit" style="max-width:100px;color:white"
                  class="btn btn-primary btn-block" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import axios from "axios";
export default {
  name: "Uitility",
  data() {
    return {
      showCollectionModal: false,
      collectionForm: {
        name: "",
        description: "",
        image: "",
        start_date: "",
        end_date: "",
      },
      collections: [],
      adminToken: localStorage.getItem("adminToken"),
    };
  },
  methods: {
    afterUploadComplete: async function (response) {
      if (response.status == "success") {
        console.log("upload successful");
        this.sendSuccess = true;
      } else {
        console.log("upload failed");
      }
    },
    uploadImage(event) {
      const file = event.target.files[0];
      this.collectionForm.image = file;
    },
    openCollectionModal() {
      this.showCollectionModal = true;
    },
    hideCollectionModal() {
      this.showCollectionModal = false;
    },

    submitCollectionForm() {
      let formData = new FormData();
      formData.append("image", this.collectionForm.image);
      formData.append("description", this.collectionForm.description);
      formData.append("name", this.collectionForm.name);
      formData.append("start_date", this.collectionForm.start_date);
      formData.append("end_date", this.collectionForm.end_date);

      axios
        .post("/api/collection", formData, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          alert("Collection created!");
        })
        .catch((errors) => {
          console.log("error");
        });
    },

    checkLoginStatus() {
      this.loading = true;
      // this.loading = true
      axios
        .get("/api/user", {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((response) => {
          this.currentUser = response.data;
          console.log("LOGGED IN");
          this.isLoggedIn = true;
          console.log(this.currentUser.name);
        })
        .catch((errors) => {
          console.log(errors);
          this.isLoggedIn = false;
        })
        .finally(() => {
          this.loading = false;
        });
      // this.loading = false
    },
  },
  mounted() {
    this.checkLoginStatus();
  },
};
</script>


<style scoped>
.options {
  border: solid 1px black;
}

.show {
  display: block !important;
}

form {
  background: #fff;
  padding: 20px;
  border-radius: 5px;
  border: 0px;
}

label {
  color: #000;
}

.text-black {
  color: #000;
}

li {
  list-style: none;
  padding: 10px;
}

ul {
  padding: 0px;
  margin: 0px;
}
</style>