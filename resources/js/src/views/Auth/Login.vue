<template>
  <div>
    <v-container class="grey lighten-5 loginscreen col-md-6">
      <v-row>
        <v-col sm="12" md="12" lg="12">
          <h2 class="text-center">Welcome to MG 1 Million ASMR Challenge</h2>
        </v-col>
      </v-row>
      <v-form ref="form" v-model="loading" lazy-validation>
        <v-row class="login-row">
          <v-col sm="12" md="12" lg="12">
            <v-text-field
              v-model="loggedinemail"
              :rules="[rules.required, rules.email]"
              label="Email"
              clearable
              hide-details
            ></v-text-field>
          </v-col>
          <v-col sm="12" md="12" lg="12">
            <v-text-field
              v-model="loggedinpassword"
              :rules="[rules.required]"
              label="Password"
              clearable
              :append-icon="show3 ? 'mdi-eye' : 'mdi-eye-off'"
              @click:append="show3 = !show3"
              :type="show3 ? 'text' : 'password'"
              hide-details
              class="mb-5"
            ></v-text-field>
          </v-col>
        </v-row>

        <v-btn
          class="col login-btn text-white"
          elevation="1"
          @click="dologin"
          large
          raised
          :loading="btnloading"
          :disabled="btnloading"
          >Login</v-btn
        >
      </v-form>

      <!-- </v-card> -->
      <v-snackbar v-model="snackbar">
        {{ erorrs.email }}

        <template v-slot:action="{ attrs }">
          <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">
            Close
          </v-btn>
        </template>
      </v-snackbar>
    </v-container>
  </div>
</template>
<script>
import loginservice from "@services/auth/login";
export default {
  name: "Login",
  components: {},
  mounted() {
    this.$nextTick(function () {
      // this.$store.commit("setAppCls", "login-screen-main");
    });
  },
  data() {
    return {
      loader: null,
      loading: false,
      btnloading: false,
      snackbar: false,
      loggedinemail: "",
      loggedinpassword: "",
      show3: false,
      password: "Password",
      erorrs: {
        email: "",
        password: "",
      },
      rules: {
        required: (value) => !!value || "Required.",
        email: (value) => {
          const pattern =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return pattern.test(value) || "Invalid e-mail.";
        },
      },
    };
  },
  methods: {
    dologin: async function () {
      if (this.$refs.form.validate()) {
        this.btnloading = true;
        var logindetail = await loginservice.dologin(
          this.loggedinemail,
          this.loggedinpassword
        );
        this.btnloading = false;
        if (logindetail.data) {
          if (logindetail.status) {
            this.$store.commit("setLoginStatus", true);
            this.$store.commit("setAuthToken", logindetail.data.token);
            var user = await loginservice.me();
            this.$store.commit("setloggedInUser", user);
            this.$router.push({ name: "auth.panel" });
          } else {
            this.erorrs.email = logindetail.data;
            this.snackbar = true;
          }
        }
      }
    },
  },
  watch: {},
};
</script>
