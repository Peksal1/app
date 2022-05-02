<template>
  <div>
    <AdminNavbar />
    <div class="container d-flex justify-content-center mt-5 p-4">
      <div class="input-group mb-3">
        <input v-model="searchKeyword" type="text" class="form-control" />
        <div class="input-group-append">
          <button @click="getAllOrders" class="btn btn-primary">Search</button>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-3" v-for="order in orders" :key="order.id">
          <div class="card">
            <div class="card-body">
              <div class="product-image">
                <img :src="`/images/${order.file_path}`" alt="" />
              </div>
              <div class="title">{{ order.text }}</div>
            </div>
            <div class="btn btn-sm btn-primary" @click="openOrderMessageModal(order.id)">
        Discuss the order
      </div>
          </div>
            
        </div>
        
      </div>
      <div class="col-md-12 text-center center-pagination">
        <Pagination
          :pagination="pagination"
          @perPage="getAllOrders()"
          @paginate="getAllOrders()"
          :offset="6"
        >
        </Pagination>
      </div>
    </div>
        <div
      class="modal"
      :class="{ show: showOrderMessageModal }"
      id="sizeModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              Add a message
            </h5>
            <br />
            <button
              type="button"
              class="close text-dark"
              data-dismiss="modal"
              aria-label="Close"
              @click="hideOrderMessageModal"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          

          </div>
                 <div
            class="modal-body"
            v-for="(order_message, index) in order_messages"
            :key="index"
          >
   
         <strong> {{order_message.user.name}} </strong> <br />
          {{order_message.message}}
          <br />
        
          </div>
         <form @submit.prevent="postOrderMessage(currentOrder)">
              <div class="form-group">
                <label for="">message</label>
                <input
                  v-model="formData.message"
                  type="text"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <input
                  type="submit"
                  value="Submit"
                  class="btn btn-primary btn-block"
                />
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
import Pagination from "../components/Pagination.vue";
export default {
  data() {
    return {
      orders: [],
      searchKeyword: "",
      adminToken: localStorage.getItem("adminToken"),
      pagination: {
        data: [],
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
      currentorder: "",
       formData: {
        message: "",
        user_id: "",
        order_id: "",
      },
        order_messages: [],
        showOrderMessageModal: false,
    };
  },
  components: {
    AdminNavbar,
    Pagination,
  },
  methods: {
       openOrderMessageModal(index) {
      this.showOrderMessageModal = true;
      this.currentOrder = index;
      this.getAllOrderMessages(index);
          
    },
    hideOrderMessageModal() {
      this.showOrderMessageModal = false;
    },
    postOrderMessage(currentOrder) {
      const messageForm = new FormData();
      messageForm.append("message", this.formData.message);
      messageForm.append("order_id", this.currentOrder);
      messageForm.append("user_id", this.currentUser.id);
      axios
        .post("/api/order_messages/" + this.currentOrder, messageForm, {
          headers: {
            Authorization: "Bearer " + this.token,
            "Content-Type": "multipart/form-data",
            boundary: messageForm._boundary,
          },
        })
        .then((response) => {
          alert("Message Sent!");
          this.getAllOrderMessages(currentOrder);        
                       
        })
        .catch((errors) => {
          console.log("error");
        });
    },
      getAllOrderMessages(currentOrder) {
      axios
        .get("/api/order_messages/" + this.currentOrder, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((res) => {
          this.order_messages = res.data;
          console.log(this.order_messages);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllOrders() {
      axios
        .get(
          `/api/orders?page=${this.pagination.current_page}&searchKeyword=${this.searchKeyword}`,
          {
            headers: {
              Authorization: "Bearer " + this.adminToken,
            },
          }
        )
        .then((res) => {
          this.orders = res.data.data;
          this.pagination = res.data;
        });
    },
  },
  created() {
    this.getAllOrders();
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Heebo:wght@500&display=swap");

.form-control {
  border-radius: 7px;
  border: 1.5px solid #e3e6ed;
}

.product-image img {
  max-width: 100%;
  width: 100%;
}

input.form-control:focus {
  box-shadow: none;
  border: 1.5px solid #e3e6ed;
  background-color: #f7f8fd;
  letter-spacing: 1px;
}

.btn-primary {
  background-color: #5878ff !important;
  border-radius: 7px;
}

.btn-primary:focus {
  box-shadow: none;
}
</style>