<template>
  <div class="container-fuiled">
    <Navbar />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.0.10/css/all.css"
      integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg"
      crossorigin="anonymous"
    />

    <div class="row" id="contatti">
      <div class="container mt-5">
        <div class="row" style="height: 550px">
          <div class="col-md-6 maps">
            <iframe
              src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=Bir%C5%A1tono%20kult%C5%ABros%20centras+(Bir%C5%A1tono%20kult%C5%ABros%20centras)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
              frameborder="0"
              style="border: 0"
              allowfullscreen
            ></iframe>
          </div>
          <div class="col-md-6">
            <h2 class="text-uppercase mt-3 font-weight-bold text-white">
              Contact me!
            </h2>
            <form action="">
              <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control mt-2"
                      placeholder="Name"
                      v-model="formData.name"
                      required
                    />
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <input
                      type="text"
                      class="form-control mt-2"
                      placeholder="Subject"
                      v-model="formData.subject"
                      required
                    />
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <input
                      type="email"
                      class="form-control mt-2"
                      placeholder="E-mail"
                      v-model="formData.Email"
                      required
                    />
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-group">
                    <input
                      type="tel"
                      class="form-control mt-2"
                      placeholder="Phone number"
                      v-model="formData.phone_number"
                      required
                    />
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <textarea
                      class="form-control"
                      id="exampleFormControlTextarea1"
                      placeholder="Message..."
                      rows="3"
                      v-model="formData.message"
                      required
                    ></textarea>
                  </div>
                </div>

                <div class="col-12">
                  <button class="btn btn-light" type="submit">Send</button>
                </div>
              </div>
            </form>
            <div class="text-white">
              <h2 class="text-uppercase mt-4 font-weight-bold">
                Aleksandras Laurs
              </h2>

              <i class="fas fa-phone mt-3"></i>
              <a href="tel:+">+370 699 65921</a><br />
              <i class="fas fa-phone mt-3"></i>
              <a href="tel:+">+370 699 65921</a><br />
              <i class="fa fa-envelope mt-3"></i> <a href="">info@peksal1.com</a
              ><br />
              <i class="fas fa-globe mt-3"></i> Jaunimo g. 4, Birštonas 59206,
              Lithuania<br />
              <i class="fas fa-globe mt-3"></i> Jaunimo g. 4, Birštonas 59206,
              Lithuania<br />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data() {
    return {
      formData: {
        name: "",
        Email: "",
        phone_number: "",
        subject: "",
        message: "",
      },
      token: localStorage.getItem("token"),
      errors: {},
    };
  },
  components: {
    Navbar,
  },
  methods: {
    createmessage() {
      axios
        .post("/api/messages", this.formData, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          console.log(response.data);

          this.errors = {};
          this.$toaster.success("Message sent successfully!");
        })
        .catch((errors) => {
          this.errors = errors.response.data.errors;
          console.log(errors.response.data.errors);
        });
    },
  },
};
</script>

<style scoped>
#contatti {
  background-color: #70c3be;
  letter-spacing: 2px;
}
#contatti a {
  color: #fff;
  text-decoration: none;
}

@media (max-width: 575.98px) {
  #contatti {
    padding-bottom: 800px;
  }
  #contatti .maps iframe {
    width: 100%;
    height: 450px;
  }
}

@media (min-width: 576px) {
  #contatti {
    padding-bottom: 800px;
  }

  #contatti .maps iframe {
    width: 100%;
    height: 450px;
  }
}

@media (min-width: 768px) {
  #contatti {
    padding-bottom: 350px;
  }

  #contatti .maps iframe {
    width: 100%;
    height: 850px;
  }
}

@media (min-width: 992px) {
  #contatti {
    padding-bottom: 200px;
  }

  #contatti .maps iframe {
    width: 100%;
    height: 700px;
  }
}

#author a {
  color: #fff;
  text-decoration: none;
}
</style>