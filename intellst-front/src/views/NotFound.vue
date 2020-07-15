<template>
  <div id="notfound">
    <v-card class="notfound-bg"></v-card>
    <v-flex xs12 class="notfound">
      <div class="notfound-404">
        <h1 style="text-transform: uppercase;">404</h1>
      </div>
      <h2>
        The page you are trying to get to never existed in this reality, or has
        migrated to a parallel universe.
      </h2>
      <h2>
        Try going back to home page and repeating your action. Or, contact
        helpdesk for support.
      </h2>
      <v-btn
        to="/"
        text
        color="error"
        class="my-4"
        rounded
        large
        style="background-color: white; font-weight: bold;"
        >Go Home</v-btn
      >
    </v-flex>
  </div>
</template>
