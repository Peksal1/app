<template>
  <div class="container-fuiled">
    <Navbar />
    <div class="aboutus-area">
      <div class="container">
        <div class="row">
          <div class="col-xs-12">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="aboutus-image float-left hidden-sm">
                <img :src="`/blog/laurs_web.jpg`" alt="" />
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="aboutus-content">
                <h2>
                  <p><span>Welcome to laurs.art</span></p>
                  I'M The Best <span>Artist</span>
                </h2>

                <p>
                  Gimiau 1949 metais. Nuo vaikystės domėjausi piešimu ir tapyba.
                  Daug laiko praleisdavau įvairiose dailės parodose, galerijose.
                  1968-1970 m. tapybos mokiausi pas žinomą Lietuvos dailininką
                  A. Steško. 1971 m. baigiau Kauno Politechnikos Institutą,
                  įgijau radioelektronikos specialybę. 1972 m. baigiau Maskvos
                  Neakivaizdinio Menų Universiteto Tapybos skyrių.
                </p>
                <p>
                  Pagrindinė piešinių tematika - gamta, Lietuvos peizažai.
                  Kūriniai buvo eksponuojami parodose Kaune, daugelis kūrinių
                  yra Jungtinėse Amerikos Valstijose asmeninėse kolekcijose.
                </p>
                <p>
                  Šiuo metu mano kūrybinė dirbtuvė yra Birštone, o gamta čia -
                  įkvepianti. Nesenai teko pabuvoti Las Vegase (JAV), kur
                  lankiausi žinomų Amerikos dailininkų šiuolaikinio meno
                  parodoje. Didelį įspūdį paliko paveikslai metafizine tematika,
                  Įkvėptas šios parodos bei kai kurių autorių darbų siužetų,
                  sukūriau naujausią savo paveikslų ciklą.
                </p>
                <div class="counter">
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="single-counter text-center">
                      <h2 class="counter"><span>15</span></h2>
                      <p>YEARS OF EXPERIENCED</p>
                    </div>

                    <div class="single-counter text-center">
                      <h2 class="counter"><span>100</span></h2>
                      <p>WEBSITES COMPLETED</p>
                    </div>

                    <div class="single-counter text-center">
                      <h2 class="counter"><span>5</span></h2>
                      <p>AWARDS WON</p>
                    </div>

                    <div class="single-counter text-center">
                      <h2 class="counter"><span>10</span></h2>
                      <p>CLIENTS</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import Navbar from "../components/Navbar.vue";
import axios from "axios";
export default {
  data() {
    return {
      currentUser: {},
      token: localStorage.getItem("token"),
      isLoggedIn: false,
      loading: true,
    };
  },
  components: {
    Navbar,
  },
  methods: {
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

    logout() {
      axios
        .post(
          "api/logout",
          {},
          {
            headers: {
              Authorization: "Bearer " + this.token,
            },
          }
        )
        .then((response) => {
          console.log(response);
          localStorage.removeItem("token");
          this.isLoggedIn = false;
          this.$router.push("/");
        })
        .catch((errors) => {
          console.log("it is not working");
          console.log(errors);
        });
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

<style scoped>
.aboutus-area {
  padding-top: 10px;
  padding-bottom: 10px;
}

/*-- aboutus Image --*/
.aboutus-image {
  margin: 0px;
  width: 480px;
  height: 500px;
}

@media only screen and (min-width: 992px) and (max-width: 1200px) {
  .aboutus-image {
    margin-right: 35px;
    width: 345px;
  }
}

@media only screen and (min-width: 768px) and (max-width: 991px) {
  .aboutus-image {
    margin-bottom: 30px;
    float: none;
  }
}

@media only screen and (max-width: 767px) {
  .aboutus-image {
    margin-bottom: 30px;
    margin-right: 0;
    float: none;
    width: auto;
  }

  .hidden-sm {
    display: block !important;
    width: 340px;
    height: 85%;
  }
}

.aboutus-image img {
  height: 100%;
  width: 100%;
}

/*-- aboutus Content --*/
.aboutus-content h2 {
  font-size: 40px;
  font-weight: 800;
  line-height: 40px;
  margin-bottom: 2px;
}

@media only screen and (max-width: 479px) {
  .aboutus-content h2 {
    font-size: 30px;
    line-height: 30px;
  }
}

.aboutus-content h2 span {
  color: #71b100;
}

.aboutus-content h4 {
  font-size: 18px;
  font-weight: 500;
  color: #9b9b9b;
  margin-bottom: 23px;
}

.aboutus-content p {
  font-size: 16px;
  line-height: 27px;
}

/*-- counter --*/
.single-counter {
  border: none;
  margin-top: 32px;
  float: left;
  width: 100%;
}

.single-counter {
  float: left;
  width: 25%;
  padding: 28px 15px 28px;
}

@media only screen and (max-width: 767px) {
  .counter .single-counter {
    width: 50%;
  }

  .counter .single-counter+.single-counter {
    border-left: none;
  }

  .counter .single-counter h2 {
    font-size: 30px;
    color: #71b100;
    line-height: 24px;
    font-family: "Open Sans", sans-serif;
    margin-bottom: 8px;
  }

  .counter .single-counter p {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 0;
    color: #8f8f8f;
  }
}
</style>