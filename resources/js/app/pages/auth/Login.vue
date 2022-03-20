<template>
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
      <div class="content-header row"></div>
      <div class="content-body">
        <div class="auth-wrapper auth-v2">
          <div class="m-0 auth-inner row">
            <div class="p-5 d-none d-lg-flex col-lg-8 align-items-center">
              <div
                class="
                  px-5
                  w-100
                  d-lg-flex
                  align-items-center
                  justify-content-center
                "
              >

                <img
                  class="img-fluid"
                  src="images/login.svg"
                  alt="Login V2"
                />
              </div>
            </div>
            <!-- /Left Text-->
            <!-- Login-->
            <div class="px-2 d-flex col-lg-4 align-items-center auth-bg p-lg-5">
              <div class="mx-auto col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2">
                <img
                  class="img-fluid"
                  src="images/logo-care.svg"
                  style="width: 25vh; margin-left: 12vh; margin-bottom: 5vh;"
                  alt="Logo"
                />
                <h4
                  class="card-title fw-bold"
                  style="margin-bottom: 1.5rem !important;  "
                >
                  Bienvenido a Care Report! 👋
                </h4>

                <form class="mt-2 auth-login-form" @submit.prevent="submit">
                  <div style="margin-bottom: 1.5rem !important">
                    <label class="form-label" for="login-email">Email</label>
                    <input
                      class="form-control"
                      type="email"
                      placeholder="Email"
                      aria-describedby="login-email"
                      tabindex="1"
                      v-model="credentials.email"
                    />
                  </div>
                  <div style="margin-bottom: 1.5rem !important">

                    <div
                      class="input-group input-group-merge form-password-toggle"
                    >
                      <input
                        class="form-control form-control-merge"
                        type="password"
                        placeholder="Password"
                        aria-describedby="login-password"
                        tabindex="2"
                        v-model="credentials.password"
                      />
                    </div>
                  </div>
                  <p v-if="showError" class="text-danger">
                    Email o Password Incorrectos...
                  </p>
                  <button
                    class="btn btn-primary w-100"
                    type="submit"
                    tabindex="4"
                  >
                    <span v-if="!this.loading">Iniciar Session</span>
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import axios from "axios";
import { mapActions } from "vuex";

export default {
  name: "Login",
  data() {
    return {
      credentials: {
        email: "admin@care.org.pe",
        password: "123456",
      },
      loading: true,
      showError: false,
    };
  },
  mounted() {
    if (this.$store.state.token !== "") {
      axios
        .post("/auth/checkToken", { token: this.$store.state.token })
        .then((response) => {
          if (response) {
            this.loading = false;
            this.$router.push("/dashboard");
          }
        })
        .catch((error) => {
          //   console.log(error);
          this.loading = false;
          this.$store.commit("clearToken");
        });
    } else {

      this.loading = false;
    }
  },
  methods: {
    ...mapActions(["login"]),
    submit: function () {
      this.$store
        .dispatch("login", this.credentials)
        .then(() => this.$router.push("/dashboard"))
        .catch((err) => console.log(err.response));
    },
  },
};
</script>
