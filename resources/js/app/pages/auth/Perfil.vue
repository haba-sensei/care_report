<template>
  <div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
      <div class="content-header row"></div>
      <div class="content-body">
        <section class="app-user-edit">
          <div class="card">
            <div class="card-body">
              <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                  <a
                    class="nav-link d-flex align-items-center active"
                    id="information-tab"
                    data-bs-toggle="tab"
                    href="#information"
                    aria-controls="information"
                    role="tab"
                    aria-selected="false"
                  >
                    <feather-icon
                      icon="UserIcon"
                      class="font-medium-4 me-25"
                      size="35"
                    />
                    <span class="d-none d-sm-block">Informacion Personal</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a
                    class="nav-link d-flex align-items-center"
                    id="account-tab"
                    data-bs-toggle="tab"
                    href="#account"
                    aria-controls="account"
                    role="tab"
                    aria-selected="true"
                  >
                    <feather-icon
                      icon="LockIcon"
                      class="font-medium-4 me-25"
                      size="35"
                    />
                    <span class="d-none d-sm-block">Cambiar Password</span>
                  </a>
                </li>
              </ul>
              <div class="tab-content">
                <div
                  class="tab-pane active"
                  id="information"
                  aria-labelledby="information-tab"
                  role="tabpanel"
                >
                  <form class="form-validate" @submit.prevent="submit">
                    <div class="row mt-1">
                      <div class="col-12">
                        <h4 class="mb-3 mt-3">
                          <feather-icon
                            icon="UserIcon"
                            class="font-medium-4 me-25"
                            size="35"
                          />
                          <span class="align-middle">Informacion Personal</span>
                        </h4>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="mb-3 mt-3">
                          <label class="form-label" for="name">NICK</label>
                          <input
                            id="name"
                            v-model="user.name"
                            type="text"
                            class="form-control"
                            placeholder="Ingresa un nick"
                            name="name"
                          />
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="mb-3 mt-3">
                          <label class="form-label" for="email">Email</label>
                          <input
                            id="email"
                            v-model="user.email"
                            type="email"
                            class="form-control"
                            placeholder="Ingresa tu email"
                            name="email"
                          />
                        </div>
                      </div>
                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                        <button
                          type="submit"
                          class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1"
                        >
                          Guardar Cambios
                        </button>
                      </div>
                    </div>
                  </form>
                </div>

                <div
                  class="tab-pane"
                  id="account"
                  aria-labelledby="account-tab"
                  role="tabpanel"
                >
                  <form class="form-validate" @submit.prevent="submitPass" >
                    <div class="row mt-1">
                      <div class="col-12">
                        <h4 class="mb-3 mt-3">
                          <feather-icon
                            icon="LockIcon"
                            class="font-medium-4 me-25"
                            size="35"
                          />
                          <span class="align-middle">Cambiar Password</span>
                        </h4>
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <div class="mb-3 mt-3">
                          <label class="form-label" for="password"
                            >Password</label
                          >
                          <input
                            id="password"
                            type="password"
                            v-model="userP.password"
                            class="form-control"
                            placeholder="Ingresa tu Password"
                            name="password"
                          />
                        </div>
                      </div>
                      <div class="col-12 d-flex flex-sm-row flex-column mt-2">
                        <button
                          type="submit"
                          class="btn btn-primary mb-1 mb-sm-0 me-0 me-sm-1"
                        >
                          Guardar Cambios
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import ToastificationContent from "../../components/ToastificationContent.vue";

export default {
  name: "Perfil",
  components: {
    ToastificationContent,
  },
  data() {
    return {
        userP: {
            password: "",
        },

    };
  },
  computed: {
    ...mapGetters({ user: "getUser" }),
  },
  methods: {
    ...mapActions(["update"]),
    submit: function () {
      this.$store
        .dispatch("update", this.user)
        .then(() => {
          this.$toast({
            component: ToastificationContent,
            props: {
              title: "Notificacion",
              icon: "BellIcon",
              text: "Se ha actualizado el usuario",
              variant: "info",
            },
          });
        })
        .catch((err) => console.log(err.response));
    },
    submitPass: function () {
        console.log( this.userP.password);
      this.$store
        .dispatch("updatePass", this.userP)
        .then(() => {
          this.userP.password = "";
          document.body.classList.add("blank-page");
          this.$router.push("/login");
        })
        .catch((err) => console.log(err.response));
    },
  },
};
</script>
