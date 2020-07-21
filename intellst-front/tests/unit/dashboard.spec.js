import { shallowMount } from "@vue/test-utils";
import Dashboard from "@/views/Dashboard.vue";
import Vue from "vue";
import Vuetify from "vuetify";
import VueRouter from "vue-router";

Vue.use(Vuetify);
Vue.use(VueRouter);

describe("Dashboard", () => {
  it("render navigation drawer", () => {
    const wrapper = shallowMount(Dashboard, {
      mocks: {
        $t: () => {},
      },
    });
    const navigation = wrapper.find("v-navigation-drawer");
    expect(navigation.exists()).toBe(false);
  });

  it("render logo", () => {
    const wrapper = shallowMount(Dashboard, {
      mocks: {
        $t: () => {},
      },
    });
    const img = wrapper.find("img");
    expect(img.exists()).toBe(true);
  });

  it("render LanguageSwitcher", () => {
    const wrapper = shallowMount(Dashboard, {
      mocks: {
        $t: () => {},
      },
    });
    const LanguageSwitcher = wrapper.find("LanguageSwitcher");
    expect(LanguageSwitcher.exists()).toBe(false);
  });

  it("render card", () => {
    const wrapper = shallowMount(Dashboard, {
      mocks: {
        $t: () => {},
      },
    });
    const card = wrapper.find("v-card");
    expect(card.exists()).toBe(false);
  });

  it("render content", () => {
    const wrapper = shallowMount(Dashboard, {
      mocks: {
        $t: () => {},
      },
    });
    const content = wrapper.find("v-content");
    expect(content.exists()).toBe(false);
  });

  it("render footer", () => {
    const wrapper = shallowMount(Dashboard, {
      mocks: {
        $t: () => {},
      },
    });
    const footer = wrapper.find("v-footer");
    expect(footer.exists()).toBe(false);
  });
});
