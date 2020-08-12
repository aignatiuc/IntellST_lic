import { mount } from "@vue/test-utils";
import NotificationPage from "@/views/NotificationPage.vue";
import Vue from "vue";
import Vuetify from "vuetify";

Vue.use(Vuetify);

describe("NotificationPage", () => {
  it("render container", () => {
    const wrapper = mount(NotificationPage, {
      mocks: {
        $t: () => {},
      },
    });
    const container = wrapper.find("v-container");
    expect(container.exists()).toBe(false);
  });

  it("render div", () => {
    const wrapper = mount(NotificationPage, {
      mocks: {
        $t: () => {},
      },
    });
    const div = wrapper.find("div");
    expect(div.exists()).toBe(true);
  });

  it("render h2", () => {
    const wrapper = mount(NotificationPage, {
      mocks: {
        $t: () => {},
      },
    });
    const h2 = wrapper.find("h2");
    expect(h2.exists()).toBe(true);
  });

  it("render p", () => {
    const wrapper = mount(NotificationPage, {
      mocks: {
        $t: () => {},
      },
    });
    const p = wrapper.find("p");
    expect(p.exists()).toBe(true);
  });

  it("render span", () => {
    const wrapper = mount(NotificationPage, {
      mocks: {
        $t: () => {},
      },
    });
    const span = wrapper.find("span");
    expect(span.exists()).toBe(true);
  });
});
