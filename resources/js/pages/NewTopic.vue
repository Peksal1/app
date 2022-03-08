<template>
  <div class="container-fuiled">
    <Navbar />
    <form action="#" @submit.prevent="newpost">
        <strong>Topic Title:</strong><br />
        <input
          type="text"
          name="title"
          v-model="formData.title"
          size="40"
          maxlength="150"
        /><br />
           <strong>Topic description:</strong><br />
        <input
          type="text"
          name="description"
          v-model="formData.description"
          size="40"
          maxlength="150"
        /><br />
        <strong>Post thumbnail:</strong><br />
        <textarea
          name="thumbnail"
          v-model="formData.thumbnail"
          rows="8"
          cols="40"
          wrap="virtual"
        ></textarea>
         <div class="p-2 w-full">
                <div class="relative">
                  <label
                    for="attachment"
                    class="leading-7 text-sm text-gray-600"
                    >Attachments</label
                  ><br />
                  <input
                    type="file"
                    accept="image/*"
                    @change="uploadImage($event)"
                    id="file-input"
                  />
                </div>
              </div>
        <input type="submit" name="submit" value="Add Topic" />

    </form>
  </div>
</template>
 
<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data() {
    return {
      formData: {
        title: "",
        description: "",
        thumbnail: "",
        image: "",
      },
      currentUser: {},
      token: localStorage.getItem("token"),
      errors: {},
    };
  },
  components: {
    Navbar,
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
      this.formData.image = file;
    },

    newpost() {
      const itemForm = new FormData();
      itemForm.append("title", this.formData.title);
      itemForm.append("description", this.formData.description);
      itemForm.append("thumbnail", this.formData.thumbnail);
      itemForm.append("image", this.formData.image);
      axios
        .post("/api/blogs", itemForm, {
          headers: {
            Authorization: "Bearer " + this.token,
            "Content-Type": "multipart/form-data",
            boundary: itemForm._boundary,
          },
        })
        .then((response) => {
          alert("Item Sent!");
          this.$router.push({
            name: "qna",
          });
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
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.currentUser = response.data;
          console.log("LOGGED IN");
          this.isLoggedIn = true;
          console.log(response.data.name);
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
    //  axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
    this.checkLoginStatus();
  },
  updated() {
    console.log(this.isLoggedIn);
  },
  watch: {
    $route(to, from) {
      this.checkLoginStatus();
    },
  },
};
</script>

<style>
.login {
  margin-left: 25rem;
}
</style>