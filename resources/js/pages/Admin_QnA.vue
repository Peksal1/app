<template>
  <div class="container-fuiled">
    <AdminNavbar />
    <div class="addtopic">
      <i class="fa fa-tachometer-alt"></i>
      <router-link class="new_feedback" :to="{ name: '/adminnewtopic' }">Create a new topic!</router-link>
    </div>

    <div class="subforum-row" v-for="qna_topic in qna_topics" v-bind:key="qna_topic.id">
      <div class="subforum-icon subforum-column center">
        <img src="https://t3.ftcdn.net/jpg/03/46/83/96/360_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg"
          style="width: 45px; height: 45px; margin-right: 25px" />
      </div>
      <div class="subforum-description subforum-column">
        <a href="#" name="topic">
          <router-link :to="{
            name: 'admintopicsposts',
            params: { id: qna_topic.id },
          }">{{ qna_topic.topic_title }}</router-link>
        </a>
        <p>{{ qna_topic.topic_description }}</p>
      </div>
      <div class="subform-stats subforum-column center">
        <span>24 posts and 15 topics</span>
      </div>
      <div class="subforum-info subforum-column">
        <b><a href="">Created</a></b> by
        <a href="">{{ qna_topic.usertopic.name }}</a>
        <br />
        on <small>{{ qna_topic.created_at }} </small>
      </div>
      <button>
        <router-link class="item" :to="{ name: 'updatetopic', params: { id: qna_topic.id } }">
          Update</router-link>
      </button>
      <div>
        <b-button class="mod" @click="$bvModal.show('bv-modal-example')">Delete<v-icon large color="teal darken-2">
            mdi-delete
          </v-icon>
        </b-button>
        <b-modal id="bv-modal-example" hide-footer>
          <template #modal-title> Delete topic </template>
          <div class="d-block text-center">
            <h3>
              Do you want to delete this {{ qna_topic.topic_title }} topic?
            </h3>
          </div>
          <b-button class="btn btn-primary mt-3" block @click="$bvModal.hide('bv-modal-example')">Cancel</b-button>
          <b-button class="btn btn-danger mt-3" block @click="deleteTopic(qna_topic.id)">delete</b-button>
        </b-modal>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
export default {
  data: function () {
    return {
      qna_topics: [],
      isLoggedIn: false,

      token: localStorage.getItem("token"),
    };
  },
  components: {
    AdminNavbar,
  },
  methods: {
    loadUsers() {
      axios.get("api/topics").then(({ data }) => (this.qna_topics = data.data));
      this.isLoggedIn = false;
      console.log(this.qna_topics);
    },
    deleteTopic(id) {
      axios
        .delete("/api/topics/" + id, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          console.log(response);
          Swal.fire({
            position: "top-end",
            icon: "success",
            title: "The topic was deleted successfully!",
            showConfirmButton: false,
            timer: 1500,
          });
          this.$router.push("/qna");
        })
        .catch((error) => {
          console.log(error);
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
          console.log(response.data.id);
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
  created() {
    this.loadUsers();
    checkLoginStatus.this();
  },
};
</script>

 <style scoped>
* {
  box-sizing: border-box;
}

.search {
  text-align: right;
}

.bland {
  font-size: 60px;
  color: #ffa309;
  font-family: "Queen of Camelot" !important;
  margin-left: 40px;
}

.home {
  font-size: 30px;
  font-family: "Queen of Camelot" !important;
  text-align: center;
}

.addtopic {
  color: #ffa309;
  text-align: right;
  font-size: 24px;
}

html {
  font-size: 14px;
  font-family: "Titillium Web", sans-serif;
  background-color: #151426;
  color: #fefefe;
}

a {
  color: #ffa309;
  font-weight: bolder;
  text-decoration: none;
}

h1 {
  font-size: 16px;
  font-weight: bolder;
}

/* ########################################### */
/*           Forums.html                       */
/* ########################################### */
.container {
  margin: 20px;
  padding: 20px;
}

.subforum {
  margin-top: 20px;
}

.subforum-title {
  background-color: #292b2e;
  padding: 5px;
  border-radius: 5px;
  margin: 4px;
  color: white;
}

.subforum-row {
  display: grid;
  grid-template-columns: 7% 60% 13% 20%;
}

.subforum-column {
  padding: 10px;
  margin: 4px;
  border-radius: 5px;
  background-color: #111314;
}

.subforum-description * {
  margin-block: 0;
}

.center {
  display: flex;
  justify-content: center;
  align-items: center;
}

.subforum-icon i {
  font-size: 45px;
}

.subforum-devider {
  display: none;
}
</style>