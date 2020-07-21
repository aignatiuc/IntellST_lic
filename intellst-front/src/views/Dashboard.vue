<template>
  <v-app id="inspire">
    <Menu />
    <v-app-bar app color="grey darken-4" clipped-left>
      <img
        :src="require('@/assets/logo.svg')"
        class="mt-2 mr-1"
        height="100"
        @click="home"
      />
      <v-spacer></v-spacer>
      <LanguageSwitcher />
      <v-btn icon class="mr-2" link to="/notifications" @click="messages = 0">
        <v-badge color="red" dot :content="messages" :value="messages">
          <v-icon>mdi-bell</v-icon>
        </v-badge>
      </v-btn>

      <User />
      <v-btn text @click="logout">
        <v-icon>mdi-exit-to-app</v-icon>
      </v-btn>
    </v-app-bar>

    <v-main>
      <router-view />
    </v-main>

    <Snackbar />

    <v-footer app padless>
      <v-card-text class="py-2 white--text text-center">
        Copyright &copy; {{ new Date().getFullYear() }}
        <strong>IntellST.</strong> All Rights Reserved
      </v-card-text>
    </v-footer>
  </v-app>
</template>

<script>
import LanguageSwitcher from "../components/LanguageSwitcher";
import Menu from "../components/Menu";
import User from "../components/NavUser";
import Snackbar from "../components/Snackbar";

export default {
  components: {
    LanguageSwitcher,
    Menu,
    User,
    Snackbar,
  },
  data() {
    return {
      messages: [],
      show: false,
    };
  },
  props: {
    source: String,
  },
  methods: {
    home() {
      this.$router.push("/");
    },
    logout() {
      localStorage.removeItem("token");
      this.$router.push("/login");
      //TODO call mutation with empty tokens
      //TODO after it redirect it to auth page
    },
    open() {
      console.log("open");
      this.$refs.userForm.open();
      // call mutation with empty tokens
      // after it redirect it to auth page
    },
  },
};
</script>
