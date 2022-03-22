<template>
  <div>
    <AdminNavbar />
    <div class="container d-flex justify-content-center mt-5 p-4">
      <div class="input-group mb-3">
        <!-- <input v-model="searchKeyword" type="text" class="form-control" /> -->
        <div class="input-group-append">
          <!-- <button @click="getAllItems" class="btn btn-primary">Search</button> -->
        </div>
      </div>
    </div>
    <section class="section-products">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-lg-6">
            <div class="header">
              <h2>User posted messages:</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <!-- painting category filtering -->

            <!-- canvas filtering -->

            <div>
              <input
                type="checkbox"
                id="0"
                class="unread"
                v-model="isread"
                :value="0"
              /><label :for="0" class="btn btn-sm border btn-block"
                >UNREAD
              </label>
            </div>
            <br />
            <div>
              <input
                type="checkbox"
                id="1"
                class="read"
                v-model="isread"
                :value="1"
              /><label :for="1" class="btn btn-sm border btn-block"
                >READ
              </label>
            </div>

            <!-- products -->
          </div>
          <div class="col-md-9">
            <div class="row">
              <!-- Single Product -->
              <div
                class="col-md-6"
                v-for="message in messages"
                v-bind:key="message.id"
              >
                <div
                  id="product-1"
                  class="single-product"
                  @click="openMessageModal"
                >
                  <div class="part-2">
                    <h3 class="product-title">
                      Subject: <strong>{{ message.subject }}</strong>
                    </h3>
                    Sent by:
                    <div class="category">{{ message.name }}</div>
                    On: {{ message.created_at }}
                    <div class="buy-btn mt-3"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12 text-center center-pagination">
          <Pagination
            :pagination="pagination"
            @perPage="loadMessages()"
            @paginate="loadMessages()"
            :offset="6"
          >
          </Pagination>
        </div>
      </div>
      <div
        class="modal"
        :class="{ show: showMessageModal }"
        id="messageModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-dark" id="exampleModalLabel">TEST</h5>
              <button
                type="button"
                class="close text-dark cursor: pointer"
                data-dismiss="modal"
                aria-label="Close"
                @click="hideMessageModal"
              >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              {{ specific_message.message }}
              <div
                @click="messageIsRead(message)"
                class="btn btn-sm btn-danger"
              >
                Read
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
import Pagination from "../components/Pagination.vue";
export default {
  data: function () {
    return {
      showMessageModal: false,
      messages: {},
      isread: {},
      specific_message: {},
      pagination: {
        data: [],
        total: 0,
        per_page: 10,
        from: 1,
        to: 0,
        current_page: 1,
      },
      isLoggedIn: false,
      adminToken: localStorage.getItem("adminToken"),
    };
  },
  components: {
    AdminNavbar,
    Pagination,
  },
  methods: {
    messageIsRead(message) {
      axios.put("/api/messages/" + message, {
        headers: {
          Authorization: "Bearer " + this.adminToken,
        },
      });
    },
    loadSpecificMessage() {
      axios
        .get("/api/message/" + this.$route.params.id, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })

        .then((response) => {
          this.specific_message = response.data;
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    openMessageModal() {
      this.showMessageModal = true;
      this.loadSpecificMessage();
    },
    hideMessageModal() {
      this.showMessageModal = false;
    },
    loadMessages() {
      axios
        .get(`/api/messages?page=${this.pagination.current_page}`, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then(({ data }) => {
          this.messages = data.data;
          this.pagination = data;
        });
      this.isLoggedIn = false;
      console.log(this.messages);
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

  created() {
    this.loadMessages();
    this.isLoggedIn = false;
  },
  mounted() {
    this.checkLoginStatus();
  },
  watch: {
    isread(after, before) {
      this.getAllItems();
    },
  },
};
</script>

<style scoped>
input.read,
input.unread {
  display: none;
}

input.read:checked + label,
input.unread:checked + label {
  background: green;
  color: white;
  box-shadow: 0px 1px 3px inset;
}
</style>