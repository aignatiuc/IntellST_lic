<template>
  <v-flex xs12>
    <v-container class="justify-content-center">
      <v-toolbar dense color="gradient" height="80">
        <v-toolbar-title>
          <h1>{{ $t("faq.title1") }}</h1>
        </v-toolbar-title>
      </v-toolbar>
      <v-expansion-panels multiple>
        <v-expansion-panel v-for="(item, i) in $t('faq.items')" :key="i">
          <v-expansion-panel-header
            class="font-weight-bold"
            v-text="item.title"
          ></v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-text-field v-text="item.text"> </v-text-field>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-container>
  </v-flex>
</template>
