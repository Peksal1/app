<template>
  <div>
    <Navbar />

    <div class="d-flex justify-content-center flex-wrap my-5">
      <h1>UNPAID ORDERS</h1>
      <v-card
        v-for="order in orders"
        v-bind:key="order.id"
        class="mx-auto my-3"
        max-width="15rem"
        min-width="15rem"
      >
        <v-img
          class="white--text align-end"
          height="10rem"
          src="https://rb.gy/rnnzki"
        >
          <v-card-title class="d-flex justify-center text-dark">{{
            order.id
          }}</v-card-title>
        </v-img>

        <v-card-subtitle class="pb-0">
          <div>
            size:
            {{ order.type }}
          </div>
        </v-card-subtitle>

        <v-card-text class="text--primary">
          <div>paint: {{ order.paint }}</div>
        </v-card-text>
        <v-card-text class="text--primary">
          <div>canvas: {{ order.canvas }}</div>
        </v-card-text>
        <hr />
        <div @click="makePayment(order)" class="btn btn-sm btn-danger">
          Pay now
        </div>
      </v-card>
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
              Add Size
            </h5>
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
            v-for="order_message in order_messages"
            :key="order_message.id"
          >
            <form @submit.prevent="submitOrderMessageForm">
              <div class="form-group">
                <label for="">message</label>
                <input
                  v-model="OrderMessageForm.message"
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
    <h1>PAID ORDERS</h1>
    <v-card
      v-for="paid_order in paid_orders"
      v-bind:key="paid_order.id"
      class="mx-auto my-3"
      max-width="15rem"
      min-width="15rem"
    >
      <v-img
        class="white--text align-end"
        height="10rem"
        src="https://rb.gy/rnnzki"
      >
        <v-card-title class="d-flex justify-center text-dark">{{
          paid_order.id
        }}</v-card-title>
      </v-img>

      <v-card-subtitle class="pb-0">
        <div>
          size:
          {{ paid_order.type }}
        </div>
      </v-card-subtitle>

      <v-card-text class="text--primary">
        <div>paint: {{ paid_order.paint }}</div>
      </v-card-text>
      <v-card-text class="text--primary">
        <div>canvas: {{ paid_order.canvas }}</div>
      </v-card-text>
      <hr />
      <div class="btn btn-sm btn-primary" @click="openOrderMessageModal">
        Discuss the order
      </div>
    </v-card>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data: function () {
    return {
      showOrderMessageModal: false,
      orders: [],
      paid_orders: [],
      order_messages: [],
      OrderMessageForm: {
        type: "",
        price_in_eur: "",
      },
      token: localStorage.getItem("token"),
      isLoggedIn: false,
    };
  },
  components: {
    Navbar,
  },

  methods: {
    loadUserOrders() {
      axios
        .get("/api/users_orders/", {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.isLoggedIn = false;

          this.orders = response.data;
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
    loadUserPaidOrders() {
      axios
        .get("/api/users_paid_orders/", {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.isLoggedIn = false;

          this.paid_orders = response.data;
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
    makePayment(order) {
      this.isPaymentLoading = true;
      axios
        .post(
          "/api/order/create-payment-session",
          {
            order: order,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        )
        .then((response) => {
          this.redirectToStripe(response.data.session_id);
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.isPaymentLoading = false;
        });
    },
    redirectToStripe(sessionID) {
      let stripe = Stripe("pk_test_d6aChIuFov53M3i5n00Fn1j200m37XdpTE");
      stripe
        .redirectToCheckout({
          sessionId: sessionID,
        })
        .then((res) => {
          console.log(res);
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
    openOrderMessageModal() {
      this.showOrderMessageModal = true;
    },
    hideOrderMessageModal() {
      this.showOrderMessageModal = false;
    },
    submitOrderMessageForm() {
      axios
        .post("/api/order_messages", this.OrderMessageForm)
        .then((res) => {
          if (res.data.status == "success") {
            this.order_messages.push(res.data.order_message);
            // reset the form
            this.OrderMessageForm = {
              message: "",
            };
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getAllOrderMessages() {
      axios
        .get("/api/order_messages")
        .then((res) => {
          this.order_messages = res.data.order_messages;
          console.log(this.order_messages);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    deleteSize(index) {
      axios
        .delete("/api/order_messages/" + this.order_messages[index].id)
        .then((res) => {
          if (res.data.status == "success") {
            this.order_messages.splice(index, 1);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  created() {},
  mounted() {
    this.checkLoginStatus();
    this.loadUserPaidOrders();
    this.loadUserOrders();
    this.getAllOrderMessages();
  },
};
</script>

<style scoped>
</style>