import Login from "@/views/Login.vue";
import { shallowMount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";

Vue.use(Vuetify);

describe("Login.vue", () => {
  it("render a form", () => {
    const wrapper = shallowMount(Login, {
      mocks: {
        $t: () => {},
      },
    });
    const form = wrapper.find("v-form");
    expect(form.exists()).toBe(false);
  });

  it("render a button", () => {
    const wrapper = shallowMount(Login, {
      mocks: {
        $t: () => {},
      },
    });
    const button = wrapper.find("v-btn");
    expect(button.exists()).toBe(false);
  });
});
